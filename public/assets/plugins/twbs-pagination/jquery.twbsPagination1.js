
/*!
 * jQuery pagination plugin v1.4
 * http://esimakin.github.io/twbs-pagination/
 *
 * Copyright 2014-2015, Eugene Simakin
 * Released under Apache 2.0 license
 * http://apache.org/licenses/LICENSE-2.0.html
 */
/*
 The changes were made by hcastro@enchufate.pe
 */
(function ($, window, document, undefined) {

    'use strict';

    var old = $.fn.twbsPagination;

    // PROTOTYPE AND CONSTRUCTOR

    var TwbsPagination = function (element, options) {
        this.$element = $(element);
        this.options = $.extend({}, $.fn.twbsPagination.defaults, options);
        if (this.options.startPage < 1993 || this.options.startPage > this.options.totalPages+1992) {
            throw new Error('Start page option is incorrect');
        }

        this.options.totalPages = parseInt(this.options.totalPages);
        if (isNaN(this.options.totalPages)) {
            throw new Error('Total pages option is not correct!');
        }

        this.options.visiblePages = parseInt(this.options.visiblePages);
        if (isNaN(this.options.visiblePages)) {
            throw new Error('Visible pages option is not correct!');
        }

        if (this.options.totalPages < this.options.visiblePages) {
            this.options.visiblePages = this.options.totalPages;
        }

        if (this.options.onPageClick instanceof Function) {
            this.$element.first().on('page', this.options.onPageClick);
        }

        if (this.options.href) {
            var match, regexp = this.options.href.replace(/[-\/\\^$*+?.|[\]]/g, '\\$&');
            regexp = regexp.replace(this.options.pageVariable, '(\\d+)');
            if ((match = new RegExp(regexp, 'i').exec(window.location.href)) != null) {
                this.options.startPage = parseInt(match[1], 10);
            }
        }

        var tagName = (typeof this.$element.prop === 'function') ?
            this.$element.prop('tagName') : this.$element.attr('tagName');

        if (tagName === 'UL') {
            this.$listContainer = this.$element;
        } else {
            this.$listContainer = $('<ul></ul>');
        }

        this.$listContainer.addClass(this.options.paginationClass);

        if (tagName !== 'UL') {
            this.$element.append(this.$listContainer);
        }

        if (this.options.initiateStartPageClick) {
            this.show(this.options.startPage);
        } else {
            this.render(this.getPages(this.options.startPage));
            this.setupEvents();
        }

        return this;
    };

    TwbsPagination.prototype = {

        constructor: TwbsPagination,

        destroy: function () {
            this.$element.empty();
            this.$element.removeData('twbs-pagination');
            this.$element.off('page');

            return this;
        },

        show: function (page) {
            if (page< 1993|| page > this.options.totalPages+1992) {
                throw new Error('Page is incorrect.');
            }

            this.render(this.getPages(page));
            this.setupEvents();

            this.$element.trigger('page', page);

            return this;
        },

        buildListItems: function (pages) {
            var listItems = [];

            if (this.options.first) {
                listItems.push(this.buildItem('first', 1993));
            }

            if (this.options.prev) {
                var prev = pages.currentPage > 1992 ? pages.currentPage - 1 : this.options.loop ? this.options.totalPages+1992  : 1993;
                while(this.options.array.indexOf(prev.toString())==-1 && prev>=1993){
                    prev--;
                }
                //console.log("Prev: "+prev);
                //console.log(this.options.array);
                //console.log(this.options.array.indexOf(prev.toString()));
                listItems.push(this.buildItem('prev', prev));
            }
            for (var i = 0; i < pages.numeric.length; i++) {
                listItems.push(this.buildItem('page', pages.numeric[(i)]));
            }
            if (this.options.next) {

                var next = pages.currentPage < this.options.totalPages+1992 ? pages.currentPage + 1 : this.options.loop ? 1 : this.options.totalPages+1992;
                var fecha = new Date();
                var anio = fecha.getFullYear();
                while(this.options.array.indexOf(next.toString())==-1 && next<=anio){
                    next++;
                }
                listItems.push(this.buildItem('next', next));
            }

            if (this.options.last) {
                listItems.push(this.buildItem('last', this.options.totalPages+1992));
            }

            return listItems;
        },

        buildItem: function (type, page) {
            var $itemContainer = $('<li></li>'),
                $itemContent = $('<a></a>'),
                itemText = null;

            itemText = this.options[type] ? this.makeText(this.options[type], page) : page;
            if(this.options.array.indexOf(page.toString())==-1){
                //console.log("Disabled: "+page);
                $itemContainer.addClass(this.options['disabledClass']);
            }else{
                $itemContainer.addClass(this.options[type + 'Class']);

                //console.log("NonDisabled: "+page);
            }
            $itemContainer.data('page', page);
            $itemContainer.data('page-type', type);
            $itemContainer.append($itemContent.attr('href', this.makeHref(page)).addClass(this.options.anchorClass).html(itemText));

            return $itemContainer;
        },

        getPages: function (currentPage) {
            var pages = [];

            var half = Math.floor(this.options.visiblePages / 2);
            var start = (currentPage - half + 1 - this.options.visiblePages % 2);
            var end = currentPage + half;
            if (start <= 1993) {
                start = 1993;
                end = this.options.visiblePages+1992;
            }
            if (end > this.options.totalPages+1992) {
                start = this.options.totalPages - this.options.visiblePages + 1993;
                end = this.options.visiblePages+start-1;
            }



            var itPage = start;
            var i = 0;
            while (itPage <= end) {
                pages.push(itPage);
                itPage++;
            }

            return {"currentPage": currentPage, "numeric": pages};
        },

        render: function (pages) {
            var _this = this;
            this.$listContainer.children().remove();
            this.$listContainer.append(this.buildListItems(pages));

            this.$listContainer.children().each(function () {
                var $this = $(this),
                    pageType = $this.data('page-type');

                switch (pageType) {
                    case 'page':
                        if ($this.data('page') === pages.currentPage) {
                            $this.addClass(_this.options.activeClass);
                        }
                        break;
                    case 'first':
                        $this.toggleClass(_this.options.disabledClass, pages.currentPage === 1993);
                        break;
                    case 'last':
                        $this.toggleClass(_this.options.disabledClass, pages.currentPage === _this.options.totalPages+1992);
                        break;
                    case 'prev':
                        $this.toggleClass(_this.options.disabledClass, !_this.options.loop && pages.currentPage === 1993);
                        break;
                    case 'next':
                        $this.toggleClass(_this.options.disabledClass,
                            !_this.options.loop && pages.currentPage === _this.options.totalPages+1992);
                        break;
                    default:
                        break;
                }

            });
        },

        setupEvents: function () {
            var _this = this;
            this.$listContainer.find('li').each(function () {
                var $this = $(this);
                $this.off();
                if ($this.hasClass(_this.options.disabledClass) || $this.hasClass(_this.options.activeClass)) {
                    $this.on('click', false);
                    return;
                }
                $this.click(function (evt) {
                    // Prevent click event if href is not set.
                    !_this.options.href && evt.preventDefault();
                    _this.show(parseInt($this.data('page')));
                });
            });
        },

        makeHref: function (page) {
            return this.options.href ? this.makeText(this.options.href, page) : "#";
        },

        makeText: function (text, page) {
            return text.replace(this.options.pageVariable, page)
                .replace(this.options.totalPagesVariable, this.options.totalPages)
        }

    };

    // PLUGIN DEFINITION

    $.fn.twbsPagination = function (option) {
        var args = Array.prototype.slice.call(arguments, 1);
        var methodReturn;

        var $this = $(this);
        var data = $this.data('twbs-pagination');
        var options = typeof option === 'object' ? option : {};

        if (!data) $this.data('twbs-pagination', (data = new TwbsPagination(this, options) ));
        if (typeof option === 'string') methodReturn = data[ option ].apply(data, args);

        return ( methodReturn === undefined ) ? $this : methodReturn;
    };

    $.fn.twbsPagination.defaults = {
        totalPages: 1,
        startPage: 1,
        visiblePages: 5,
        initiateStartPageClick: true,
        href: false,
        pageVariable: '{{page}}',
        totalPagesVariable: '{{total_pages}}',
        page: null,
        array: null,
        first: 'First',
        prev: 'Previous',
        next: 'Next',
        last: 'Last',
        loop: false,
        onPageClick: null,
        paginationClass: 'pagination',
        nextClass: 'next',
        prevClass: 'prev',
        lastClass: 'last',
        firstClass: 'first',
        pageClass: 'page',
        activeClass: 'active',
        disabledClass: 'disabled',
        anchorClass: 'page-link'
    };

    $.fn.twbsPagination.Constructor = TwbsPagination;

    $.fn.twbsPagination.noConflict = function () {
        $.fn.twbsPagination = old;
        return this;
    };

})(window.jQuery, window, document);