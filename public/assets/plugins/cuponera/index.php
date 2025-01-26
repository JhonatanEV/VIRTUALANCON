<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>1</title>
	<link rel="stylesheet" href="">
</head>
<body>
	
	<div class="flip-book-container" src="example.pdf">

  </div>


	<script src="js/libs/jquery.min.js"></script>
    <script src="js/libs/html2canvas.min.js"></script>
    <script src="js/libs/three.min.js"></script>
    <script src="js/libs/pdf.min.js"></script>

    <script src="js/dist/3dflipbook.min.js"></script>
    <script  type="text/javascript">

    	var options = {
	    pdf: 'example.pdf', // you should use this property or pageCallback and pages to specify your book
	    pageCallback: function(n) { // this function has to return source description for FlipBook page
	      // for image sources
	      var imageDescription = {
	        type: 'image',
	        src: 'images/MPP/' + n + '.jpg',
	        interactive: false
	      };
	      // for html sources
	      var htmlDescription = {
	        type: 'html',
	        src: 'example/' + n + '.html',
	        interactive: true // or false - if your page interact with the user then use true
	      };
	      // for blank page
	      var blankDescription = {
	        type: 'blank'
	      };
	      return htmlDescription; // or imageDescription or blankDescription
	    },
	    pages: 10, // amount of pages
	    controlsProps: { // set of optional properties that allow to customize 3D FlipBook control
	      downloadURL: 'example.pdf'
	    },
	    propertiesCallback: function(props) { // optional function - it lets to customize 3D FlipBook
	      props.page.depth /= 2;
	      props.cover.binderTexture = 'exampleTexture.jpg';
	      props.cssLayersLoader = function(n, clb) {// n - page number
	        clb([{
	          css: '.heading {margin-top: 200px;background-color: red;}',
	          html: '<h1 class="heading">Hello</h1>',
	          js: function (jContainer, props) { // jContainer - jQuery element that contains HTML Layer content
	            console.log('init');
	            return { // set of callbacks
	              hide: function() {console.log('hide');},
	              hidden: function() {console.log('hidden');},
	              show: function() {console.log('show');},
	              shown: function() {console.log('shown');},
	              dispose: function() {console.log('dispose');}
	            };
	          }
	        }]);
	      };
	      return props;
	    },
	    template: { // by means this property you can choose appropriate skin
	      html: 'default-book-view.html',
	      styles: [
	        'css/black-book-view.css'// or one of white-book-view.css, short-white-book-view.css, shart-black-book-view.css
	      ],
	      links: [{
	        rel: 'stylesheet',
	        href: 'css/font-awesome.min.css'
	      }],
	      script: 'js/default-book-view.js',
	      printStyle: undefined, // or you can set your stylesheet for printing ('print-style.css')
	      sounds: {
	        startFlip: 'sounds/start-flip.mp3',
	        endFlip: 'sounds/end-flip.mp3'
	      }
	    },
	    pdfLinks: {
	      handler: function(type, destination) { // type: 'internal' (destination - page number), 'external' (destination - url)
	        return true; // true - prevent default handler, false - call default handler
	      }
	    },
	    autoNavigation: {
	      urlParam: 'fb3d-page', // url query param name for deep linking: http://example.com?fb3d-page=10
	      navigates: 1, // number of instances that will be navigated automatically,
	      pageN: undefined // auto open page pageN
	    },
	    bookStyle: 'volume', // volume, flat or volume-paddings
	    activateFullScreen: false, // activate fullscreen if it is possible (API can only be initiated by a user gesture)
	    ready: function(scene) { // optional function - this function executes when loading is complete

	    },
	    error: function(e) { // optional function for notification about errors

	    }
	  };
	  var book = $('container-selector').FlipBook(options);
    </script>
</body>
</html>