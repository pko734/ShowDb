/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};

/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {

/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId])
/******/ 			return installedModules[moduleId].exports;

/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};

/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);

/******/ 		// Flag the module as loaded
/******/ 		module.l = true;

/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}


/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;

/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;

/******/ 	// identity function for calling harmory imports with the correct context
/******/ 	__webpack_require__.i = function(value) { return value; };

/******/ 	// define getter function for harmory exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		Object.defineProperty(exports, name, {
/******/ 			configurable: false,
/******/ 			enumerable: true,
/******/ 			get: getter
/******/ 		});
/******/ 	};

/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};

/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };

/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";

/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 8);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ function(module, exports) {

eval("/** ADMIN **/\n//deletes\n$(document).ready(function() {\n    $('#show-note-column .notedeletebutton').on('click', function() {\n\tvar that = this;\n\n\t$('#show-note-delete-form').attr('action',\n\t\t\t\t\t '/shows/' +\n\t\t\t\t\t $(that).attr('data-parent-id') +\n\t\t\t\t\t '/notes/' +\n\t\t\t\t\t $(that).attr('data-note-id'));\n\n\t$('#show-note-delete-form').submit();\n    });\n\n    $('#song-note-column .notedeletebutton').on('click', function() {\n\tvar that = this;\n\n\t$('#song-note-delete-form').attr('action',\n\t\t\t\t\t '/songs/' +\n\t\t\t\t\t $(that).attr('data-parent-id') +\n\t\t\t\t\t '/notes/' +\n\t\t\t\t\t $(that).attr('data-note-id'));\n\n\t$('#song-note-delete-form').submit();\n    });\n\n    $('#video-note-column .notedeletebutton').on('click', function() {\n\tvar that = this;\n\n\t$('#video-note-delete-form').attr('action',\n\t\t\t\t\t  '/setlistitems/' +\n\t\t\t\t\t  $(that).attr('data-parent-id') +\n\t\t\t\t\t  '/video/' +\n\t\t\t\t\t  $(that).attr('data-note-id'));\n\n\t$('#video-note-delete-form').submit();\n\n    });\n\n\n    // approves\n    $('#show-note-column .noteapprovebutton').on('click', function() {\n\tvar that = this;\n\n\t$('#show-note-approve-form').attr('action',\n\t\t\t\t\t  '/shows/' +\n\t\t\t\t\t  $(that).attr('data-parent-id') +\n\t\t\t\t\t  '/notes/' +\n\t\t\t\t\t  $(that).attr('data-note-id'));\n\n\t$('#show-note-approve-form').submit();\n    });\n\n    $('#song-note-column .noteapprovebutton').on('click', function() {\n\tvar that = this;\n\n\t$('#song-note-approve-form').attr('action',\n\t\t\t\t\t  '/songs/' +\n\t\t\t\t\t  $(that).attr('data-parent-id') +\n\t\t\t\t\t  '/notes/' +\n\t\t\t\t\t  $(that).attr('data-note-id'));\n\n\t$('#song-note-approve-form').submit();\n    });\n\n    $('#video-note-column .noteapprovebutton').on('click', function() {\n\tvar that = this;\n\n\t$('#video-note-approve-form').attr('action',\n\t\t\t\t\t   '/setlistitems/' +\n\t\t\t\t\t   $(that).attr('data-parent-id') +\n\t\t\t\t\t   '/video/' +\n\t\t\t\t\t   $(that).attr('data-note-id'));\n\n\t$('#video-note-approve-form').submit();\n\n    });\n\n});\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiMC5qcyIsInNvdXJjZXMiOlsid2VicGFjazovLy9yZXNvdXJjZXMvYXNzZXRzL2pzL2FkbWluLmpzP2QwZWUiXSwic291cmNlc0NvbnRlbnQiOlsiLyoqIEFETUlOICoqL1xuLy9kZWxldGVzXG4kKGRvY3VtZW50KS5yZWFkeShmdW5jdGlvbigpIHtcbiAgICAkKCcjc2hvdy1ub3RlLWNvbHVtbiAubm90ZWRlbGV0ZWJ1dHRvbicpLm9uKCdjbGljaycsIGZ1bmN0aW9uKCkge1xuXHR2YXIgdGhhdCA9IHRoaXM7XG5cblx0JCgnI3Nob3ctbm90ZS1kZWxldGUtZm9ybScpLmF0dHIoJ2FjdGlvbicsXG5cdFx0XHRcdFx0ICcvc2hvd3MvJyArXG5cdFx0XHRcdFx0ICQodGhhdCkuYXR0cignZGF0YS1wYXJlbnQtaWQnKSArXG5cdFx0XHRcdFx0ICcvbm90ZXMvJyArXG5cdFx0XHRcdFx0ICQodGhhdCkuYXR0cignZGF0YS1ub3RlLWlkJykpO1xuXG5cdCQoJyNzaG93LW5vdGUtZGVsZXRlLWZvcm0nKS5zdWJtaXQoKTtcbiAgICB9KTtcblxuICAgICQoJyNzb25nLW5vdGUtY29sdW1uIC5ub3RlZGVsZXRlYnV0dG9uJykub24oJ2NsaWNrJywgZnVuY3Rpb24oKSB7XG5cdHZhciB0aGF0ID0gdGhpcztcblxuXHQkKCcjc29uZy1ub3RlLWRlbGV0ZS1mb3JtJykuYXR0cignYWN0aW9uJyxcblx0XHRcdFx0XHQgJy9zb25ncy8nICtcblx0XHRcdFx0XHQgJCh0aGF0KS5hdHRyKCdkYXRhLXBhcmVudC1pZCcpICtcblx0XHRcdFx0XHQgJy9ub3Rlcy8nICtcblx0XHRcdFx0XHQgJCh0aGF0KS5hdHRyKCdkYXRhLW5vdGUtaWQnKSk7XG5cblx0JCgnI3Nvbmctbm90ZS1kZWxldGUtZm9ybScpLnN1Ym1pdCgpO1xuICAgIH0pO1xuXG4gICAgJCgnI3ZpZGVvLW5vdGUtY29sdW1uIC5ub3RlZGVsZXRlYnV0dG9uJykub24oJ2NsaWNrJywgZnVuY3Rpb24oKSB7XG5cdHZhciB0aGF0ID0gdGhpcztcblxuXHQkKCcjdmlkZW8tbm90ZS1kZWxldGUtZm9ybScpLmF0dHIoJ2FjdGlvbicsXG5cdFx0XHRcdFx0ICAnL3NldGxpc3RpdGVtcy8nICtcblx0XHRcdFx0XHQgICQodGhhdCkuYXR0cignZGF0YS1wYXJlbnQtaWQnKSArXG5cdFx0XHRcdFx0ICAnL3ZpZGVvLycgK1xuXHRcdFx0XHRcdCAgJCh0aGF0KS5hdHRyKCdkYXRhLW5vdGUtaWQnKSk7XG5cblx0JCgnI3ZpZGVvLW5vdGUtZGVsZXRlLWZvcm0nKS5zdWJtaXQoKTtcblxuICAgIH0pO1xuXG5cbiAgICAvLyBhcHByb3Zlc1xuICAgICQoJyNzaG93LW5vdGUtY29sdW1uIC5ub3RlYXBwcm92ZWJ1dHRvbicpLm9uKCdjbGljaycsIGZ1bmN0aW9uKCkge1xuXHR2YXIgdGhhdCA9IHRoaXM7XG5cblx0JCgnI3Nob3ctbm90ZS1hcHByb3ZlLWZvcm0nKS5hdHRyKCdhY3Rpb24nLFxuXHRcdFx0XHRcdCAgJy9zaG93cy8nICtcblx0XHRcdFx0XHQgICQodGhhdCkuYXR0cignZGF0YS1wYXJlbnQtaWQnKSArXG5cdFx0XHRcdFx0ICAnL25vdGVzLycgK1xuXHRcdFx0XHRcdCAgJCh0aGF0KS5hdHRyKCdkYXRhLW5vdGUtaWQnKSk7XG5cblx0JCgnI3Nob3ctbm90ZS1hcHByb3ZlLWZvcm0nKS5zdWJtaXQoKTtcbiAgICB9KTtcblxuICAgICQoJyNzb25nLW5vdGUtY29sdW1uIC5ub3RlYXBwcm92ZWJ1dHRvbicpLm9uKCdjbGljaycsIGZ1bmN0aW9uKCkge1xuXHR2YXIgdGhhdCA9IHRoaXM7XG5cblx0JCgnI3Nvbmctbm90ZS1hcHByb3ZlLWZvcm0nKS5hdHRyKCdhY3Rpb24nLFxuXHRcdFx0XHRcdCAgJy9zb25ncy8nICtcblx0XHRcdFx0XHQgICQodGhhdCkuYXR0cignZGF0YS1wYXJlbnQtaWQnKSArXG5cdFx0XHRcdFx0ICAnL25vdGVzLycgK1xuXHRcdFx0XHRcdCAgJCh0aGF0KS5hdHRyKCdkYXRhLW5vdGUtaWQnKSk7XG5cblx0JCgnI3Nvbmctbm90ZS1hcHByb3ZlLWZvcm0nKS5zdWJtaXQoKTtcbiAgICB9KTtcblxuICAgICQoJyN2aWRlby1ub3RlLWNvbHVtbiAubm90ZWFwcHJvdmVidXR0b24nKS5vbignY2xpY2snLCBmdW5jdGlvbigpIHtcblx0dmFyIHRoYXQgPSB0aGlzO1xuXG5cdCQoJyN2aWRlby1ub3RlLWFwcHJvdmUtZm9ybScpLmF0dHIoJ2FjdGlvbicsXG5cdFx0XHRcdFx0ICAgJy9zZXRsaXN0aXRlbXMvJyArXG5cdFx0XHRcdFx0ICAgJCh0aGF0KS5hdHRyKCdkYXRhLXBhcmVudC1pZCcpICtcblx0XHRcdFx0XHQgICAnL3ZpZGVvLycgK1xuXHRcdFx0XHRcdCAgICQodGhhdCkuYXR0cignZGF0YS1ub3RlLWlkJykpO1xuXG5cdCQoJyN2aWRlby1ub3RlLWFwcHJvdmUtZm9ybScpLnN1Ym1pdCgpO1xuXG4gICAgfSk7XG5cbn0pO1xuXG5cblxuLy8gV0VCUEFDSyBGT09URVIgLy9cbi8vIHJlc291cmNlcy9hc3NldHMvanMvYWRtaW4uanMiXSwibWFwcGluZ3MiOiJBQUFBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOyIsInNvdXJjZVJvb3QiOiIifQ==");

/***/ },
/* 1 */
/***/ function(module, exports) {

eval("$(document).ready(function() {\n    var songs = new Bloodhound({\n\tdatumTokenizer: Bloodhound.tokenizers.whitespace,\n\tqueryTokenizer: Bloodhound.tokenizers.whitespace,\n\tprefetch: '/data/songs'\n    });\n\n    $('#addbutton').click(function() {\n\t$('#setlisttable tbody').append('<tr><td><span class=\"ac-song-title-new\"><input name=\"songs[]\" value=\"\" class=\"form-control typeahead\" type=\"text\" placeholder=\"Song Title\"></span></td></tr>');\n\n\t$('.ac-song-title-new .typeahead').typeahead({\n\t    highlight: true,\n\t    cache: false\n\t}, {\n\t    name: 'songs',\n\t    source: songs,\n\t});\n\n\t$('.ac-song-title-new')\n\t    .removeClass('ac-song-title-new')\n\t    .addClass('ac-song-title');\n\n\t$('html, body').scrollTop( $(document).height() );\n    });\n\n    var songs = new Bloodhound({\n\tdatumTokenizer: Bloodhound.tokenizers.whitespace,\n\tqueryTokenizer: Bloodhound.tokenizers.whitespace,\n\tprefetch: '/data/songs'\n    });\n\n    // passing in `null` for the `options` arguments will result in the default\n    // options being used\n    $('#setlisttable .ac-song-title .typeahead').typeahead({\n\thighlight: true,\n\tcache: false\n    }, {\n\tname: 'songs',\n\tsource: songs,\n    });\n\n});\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiMS5qcyIsInNvdXJjZXMiOlsid2VicGFjazovLy9yZXNvdXJjZXMvYXNzZXRzL2pzL2VkaXRzaG93LmpzP2VjMDQiXSwic291cmNlc0NvbnRlbnQiOlsiJChkb2N1bWVudCkucmVhZHkoZnVuY3Rpb24oKSB7XG4gICAgdmFyIHNvbmdzID0gbmV3IEJsb29kaG91bmQoe1xuXHRkYXR1bVRva2VuaXplcjogQmxvb2Rob3VuZC50b2tlbml6ZXJzLndoaXRlc3BhY2UsXG5cdHF1ZXJ5VG9rZW5pemVyOiBCbG9vZGhvdW5kLnRva2VuaXplcnMud2hpdGVzcGFjZSxcblx0cHJlZmV0Y2g6ICcvZGF0YS9zb25ncydcbiAgICB9KTtcblxuICAgICQoJyNhZGRidXR0b24nKS5jbGljayhmdW5jdGlvbigpIHtcblx0JCgnI3NldGxpc3R0YWJsZSB0Ym9keScpLmFwcGVuZCgnPHRyPjx0ZD48c3BhbiBjbGFzcz1cImFjLXNvbmctdGl0bGUtbmV3XCI+PGlucHV0IG5hbWU9XCJzb25nc1tdXCIgdmFsdWU9XCJcIiBjbGFzcz1cImZvcm0tY29udHJvbCB0eXBlYWhlYWRcIiB0eXBlPVwidGV4dFwiIHBsYWNlaG9sZGVyPVwiU29uZyBUaXRsZVwiPjwvc3Bhbj48L3RkPjwvdHI+Jyk7XG5cblx0JCgnLmFjLXNvbmctdGl0bGUtbmV3IC50eXBlYWhlYWQnKS50eXBlYWhlYWQoe1xuXHQgICAgaGlnaGxpZ2h0OiB0cnVlLFxuXHQgICAgY2FjaGU6IGZhbHNlXG5cdH0sIHtcblx0ICAgIG5hbWU6ICdzb25ncycsXG5cdCAgICBzb3VyY2U6IHNvbmdzLFxuXHR9KTtcblxuXHQkKCcuYWMtc29uZy10aXRsZS1uZXcnKVxuXHQgICAgLnJlbW92ZUNsYXNzKCdhYy1zb25nLXRpdGxlLW5ldycpXG5cdCAgICAuYWRkQ2xhc3MoJ2FjLXNvbmctdGl0bGUnKTtcblxuXHQkKCdodG1sLCBib2R5Jykuc2Nyb2xsVG9wKCAkKGRvY3VtZW50KS5oZWlnaHQoKSApO1xuICAgIH0pO1xuXG4gICAgdmFyIHNvbmdzID0gbmV3IEJsb29kaG91bmQoe1xuXHRkYXR1bVRva2VuaXplcjogQmxvb2Rob3VuZC50b2tlbml6ZXJzLndoaXRlc3BhY2UsXG5cdHF1ZXJ5VG9rZW5pemVyOiBCbG9vZGhvdW5kLnRva2VuaXplcnMud2hpdGVzcGFjZSxcblx0cHJlZmV0Y2g6ICcvZGF0YS9zb25ncydcbiAgICB9KTtcblxuICAgIC8vIHBhc3NpbmcgaW4gYG51bGxgIGZvciB0aGUgYG9wdGlvbnNgIGFyZ3VtZW50cyB3aWxsIHJlc3VsdCBpbiB0aGUgZGVmYXVsdFxuICAgIC8vIG9wdGlvbnMgYmVpbmcgdXNlZFxuICAgICQoJyNzZXRsaXN0dGFibGUgLmFjLXNvbmctdGl0bGUgLnR5cGVhaGVhZCcpLnR5cGVhaGVhZCh7XG5cdGhpZ2hsaWdodDogdHJ1ZSxcblx0Y2FjaGU6IGZhbHNlXG4gICAgfSwge1xuXHRuYW1lOiAnc29uZ3MnLFxuXHRzb3VyY2U6IHNvbmdzLFxuICAgIH0pO1xuXG59KTtcblxuXG5cbi8vIFdFQlBBQ0sgRk9PVEVSIC8vXG4vLyByZXNvdXJjZXMvYXNzZXRzL2pzL2VkaXRzaG93LmpzIl0sIm1hcHBpbmdzIjoiQUFBQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7O0FBR0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOyIsInNvdXJjZVJvb3QiOiIifQ==");

/***/ },
/* 2 */
/***/ function(module, exports) {

eval("$(document).ready(function() {\n    datbutton = false;\n\n    $('#addbutton').click(function() {\n\t$('#showtable tbody').append('<tr><td><input name=\"dates[]\" value=\"\" class=\"form-control\" type=\"text\" placeholder=\"YYYY-MM-DD\"></td><td></td><td><input name=\"venues[]\" value=\"\" class=\"form-control\" type=\"text\" placeholder=\"Venue - City, State\"></td></tr>');\n\n\tif(!datbutton) {\n\t    $('#showtable').append( '<button id=\"addbutton\" type=\"submit\" class=\"btn btn-primary\">Submit</button>');\n\t    datbutton = true;\n\t}\n\n\t$('html, body').scrollTop( $(document).height() );\n    });\n\n    $('.add-show-link').on('click', function(e) {\n\te.preventDefault();\n\t$('#user-add-show-form').attr('action', '/users/shows/' + $(this).attr('data-show-id'));\n\t$('#user-add-show-form').submit();\n\treturn false;\n    });\n\n    $('.remove-show-link').on('click', function(e) {\n\te.preventDefault();\n\t$('#user-remove-show-form').attr('action', '/users/shows/' + $(this).attr('data-show-id'));\n\t$('#user-remove-show-form').submit();\n\treturn false;\n    });\n});\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiMi5qcyIsInNvdXJjZXMiOlsid2VicGFjazovLy9yZXNvdXJjZXMvYXNzZXRzL2pzL2luZGV4c2hvd3MuanM/YjI2OSJdLCJzb3VyY2VzQ29udGVudCI6WyIkKGRvY3VtZW50KS5yZWFkeShmdW5jdGlvbigpIHtcbiAgICBkYXRidXR0b24gPSBmYWxzZTtcblxuICAgICQoJyNhZGRidXR0b24nKS5jbGljayhmdW5jdGlvbigpIHtcblx0JCgnI3Nob3d0YWJsZSB0Ym9keScpLmFwcGVuZCgnPHRyPjx0ZD48aW5wdXQgbmFtZT1cImRhdGVzW11cIiB2YWx1ZT1cIlwiIGNsYXNzPVwiZm9ybS1jb250cm9sXCIgdHlwZT1cInRleHRcIiBwbGFjZWhvbGRlcj1cIllZWVktTU0tRERcIj48L3RkPjx0ZD48L3RkPjx0ZD48aW5wdXQgbmFtZT1cInZlbnVlc1tdXCIgdmFsdWU9XCJcIiBjbGFzcz1cImZvcm0tY29udHJvbFwiIHR5cGU9XCJ0ZXh0XCIgcGxhY2Vob2xkZXI9XCJWZW51ZSAtIENpdHksIFN0YXRlXCI+PC90ZD48L3RyPicpO1xuXG5cdGlmKCFkYXRidXR0b24pIHtcblx0ICAgICQoJyNzaG93dGFibGUnKS5hcHBlbmQoICc8YnV0dG9uIGlkPVwiYWRkYnV0dG9uXCIgdHlwZT1cInN1Ym1pdFwiIGNsYXNzPVwiYnRuIGJ0bi1wcmltYXJ5XCI+U3VibWl0PC9idXR0b24+Jyk7XG5cdCAgICBkYXRidXR0b24gPSB0cnVlO1xuXHR9XG5cblx0JCgnaHRtbCwgYm9keScpLnNjcm9sbFRvcCggJChkb2N1bWVudCkuaGVpZ2h0KCkgKTtcbiAgICB9KTtcblxuICAgICQoJy5hZGQtc2hvdy1saW5rJykub24oJ2NsaWNrJywgZnVuY3Rpb24oZSkge1xuXHRlLnByZXZlbnREZWZhdWx0KCk7XG5cdCQoJyN1c2VyLWFkZC1zaG93LWZvcm0nKS5hdHRyKCdhY3Rpb24nLCAnL3VzZXJzL3Nob3dzLycgKyAkKHRoaXMpLmF0dHIoJ2RhdGEtc2hvdy1pZCcpKTtcblx0JCgnI3VzZXItYWRkLXNob3ctZm9ybScpLnN1Ym1pdCgpO1xuXHRyZXR1cm4gZmFsc2U7XG4gICAgfSk7XG5cbiAgICAkKCcucmVtb3ZlLXNob3ctbGluaycpLm9uKCdjbGljaycsIGZ1bmN0aW9uKGUpIHtcblx0ZS5wcmV2ZW50RGVmYXVsdCgpO1xuXHQkKCcjdXNlci1yZW1vdmUtc2hvdy1mb3JtJykuYXR0cignYWN0aW9uJywgJy91c2Vycy9zaG93cy8nICsgJCh0aGlzKS5hdHRyKCdkYXRhLXNob3ctaWQnKSk7XG5cdCQoJyN1c2VyLXJlbW92ZS1zaG93LWZvcm0nKS5zdWJtaXQoKTtcblx0cmV0dXJuIGZhbHNlO1xuICAgIH0pO1xufSk7XG5cblxuXG4vLyBXRUJQQUNLIEZPT1RFUiAvL1xuLy8gcmVzb3VyY2VzL2Fzc2V0cy9qcy9pbmRleHNob3dzLmpzIl0sIm1hcHBpbmdzIjoiQUFBQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTsiLCJzb3VyY2VSb290IjoiIn0=");

/***/ },
/* 3 */
/***/ function(module, exports) {

eval("$(document).ready(function() {\n    $('#addbutton').click(function() {\n\t$('#songtable tbody').append('<tr><td><input name=\"songs[]\" value=\"\" class=\"form-control\" type=\"text\" placeholder=\"Song Title\"></td><td></td></tr>');\n\n\t$('html, body').scrollTop( $(document).height() );\n    });\n});\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiMy5qcyIsInNvdXJjZXMiOlsid2VicGFjazovLy9yZXNvdXJjZXMvYXNzZXRzL2pzL2luZGV4c29uZ3MuanM/NzkwYSJdLCJzb3VyY2VzQ29udGVudCI6WyIkKGRvY3VtZW50KS5yZWFkeShmdW5jdGlvbigpIHtcbiAgICAkKCcjYWRkYnV0dG9uJykuY2xpY2soZnVuY3Rpb24oKSB7XG5cdCQoJyNzb25ndGFibGUgdGJvZHknKS5hcHBlbmQoJzx0cj48dGQ+PGlucHV0IG5hbWU9XCJzb25nc1tdXCIgdmFsdWU9XCJcIiBjbGFzcz1cImZvcm0tY29udHJvbFwiIHR5cGU9XCJ0ZXh0XCIgcGxhY2Vob2xkZXI9XCJTb25nIFRpdGxlXCI+PC90ZD48dGQ+PC90ZD48L3RyPicpO1xuXG5cdCQoJ2h0bWwsIGJvZHknKS5zY3JvbGxUb3AoICQoZG9jdW1lbnQpLmhlaWdodCgpICk7XG4gICAgfSk7XG59KTtcblxuXG5cbi8vIFdFQlBBQ0sgRk9PVEVSIC8vXG4vLyByZXNvdXJjZXMvYXNzZXRzL2pzL2luZGV4c29uZ3MuanMiXSwibWFwcGluZ3MiOiJBQUFBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOyIsInNvdXJjZVJvb3QiOiIifQ==");

/***/ },
/* 4 */
/***/ function(module, exports) {

eval("$(document).ready(function() {\n    $cb = new Clipboard('#usershare');\n    $cb.on('success', function(e) {\n\t$('#usershare').attr('data-original-title', 'Copied to clipboard!').tooltip('fixTitle').tooltip('show');\n    });\n\n    $('[data-toggle=\"tooltip\"]').tooltip();\n});\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiNC5qcyIsInNvdXJjZXMiOlsid2VicGFjazovLy9yZXNvdXJjZXMvYXNzZXRzL2pzL2luZGV4dXNlcnMuanM/N2U1ZCJdLCJzb3VyY2VzQ29udGVudCI6WyIkKGRvY3VtZW50KS5yZWFkeShmdW5jdGlvbigpIHtcbiAgICAkY2IgPSBuZXcgQ2xpcGJvYXJkKCcjdXNlcnNoYXJlJyk7XG4gICAgJGNiLm9uKCdzdWNjZXNzJywgZnVuY3Rpb24oZSkge1xuXHQkKCcjdXNlcnNoYXJlJykuYXR0cignZGF0YS1vcmlnaW5hbC10aXRsZScsICdDb3BpZWQgdG8gY2xpcGJvYXJkIScpLnRvb2x0aXAoJ2ZpeFRpdGxlJykudG9vbHRpcCgnc2hvdycpO1xuICAgIH0pO1xuXG4gICAgJCgnW2RhdGEtdG9nZ2xlPVwidG9vbHRpcFwiXScpLnRvb2x0aXAoKTtcbn0pO1xuXG5cblxuLy8gV0VCUEFDSyBGT09URVIgLy9cbi8vIHJlc291cmNlcy9hc3NldHMvanMvaW5kZXh1c2Vycy5qcyJdLCJtYXBwaW5ncyI6IkFBQUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTsiLCJzb3VyY2VSb290IjoiIn0=");

/***/ },
/* 5 */
/***/ function(module, exports) {

eval("$(document).ready(function() {\n\n    var songs = new Bloodhound({\n\tdatumTokenizer: Bloodhound.tokenizers.whitespace,\n\tqueryTokenizer: Bloodhound.tokenizers.whitespace,\n\tprefetch: '/data/songs'\n    });\n\n\n    $('#plays-input .ac-song-title .typeahead').typeahead({\n\thighlight: true,\n\tcache: false\n    }, {\n\tname: 'songs',\n\tsource: songs,\n    });\n\n});\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiNS5qcyIsInNvdXJjZXMiOlsid2VicGFjazovLy9yZXNvdXJjZXMvYXNzZXRzL2pzL3BsYXlzb25ncy5qcz8zODBiIl0sInNvdXJjZXNDb250ZW50IjpbIiQoZG9jdW1lbnQpLnJlYWR5KGZ1bmN0aW9uKCkge1xuXG4gICAgdmFyIHNvbmdzID0gbmV3IEJsb29kaG91bmQoe1xuXHRkYXR1bVRva2VuaXplcjogQmxvb2Rob3VuZC50b2tlbml6ZXJzLndoaXRlc3BhY2UsXG5cdHF1ZXJ5VG9rZW5pemVyOiBCbG9vZGhvdW5kLnRva2VuaXplcnMud2hpdGVzcGFjZSxcblx0cHJlZmV0Y2g6ICcvZGF0YS9zb25ncydcbiAgICB9KTtcblxuXG4gICAgJCgnI3BsYXlzLWlucHV0IC5hYy1zb25nLXRpdGxlIC50eXBlYWhlYWQnKS50eXBlYWhlYWQoe1xuXHRoaWdobGlnaHQ6IHRydWUsXG5cdGNhY2hlOiBmYWxzZVxuICAgIH0sIHtcblx0bmFtZTogJ3NvbmdzJyxcblx0c291cmNlOiBzb25ncyxcbiAgICB9KTtcblxufSk7XG5cblxuXG4vLyBXRUJQQUNLIEZPT1RFUiAvL1xuLy8gcmVzb3VyY2VzL2Fzc2V0cy9qcy9wbGF5c29uZ3MuanMiXSwibWFwcGluZ3MiOiJBQUFBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTsiLCJzb3VyY2VSb290IjoiIn0=");

/***/ },
/* 6 */
/***/ function(module, exports) {

eval("$(document).ready(function() {\n\n    $('#delete-show-btn').on('click', function() {\n\tbootbox.confirm('Are you sure you want to delete this show?', function(result) {\n\t    if(result) {\n\t\t$('#delete-show-form').submit();\n\t    }\n\t});\n\n    });\n\n    $('.delete-show-note-btn').on('click', function() {\n\t$('#delete-show-note-form').attr('action', $('#delete-show-note-form').attr('action') + $(this).attr('data-note-id'));\n\t$('#delete-show-note-form').submit();\n\t$('.delete-show-note-btn').attr('disabled', true);\n    });\n\n    datbutton = false;\n    $('#add-show-note-btn').click(function() {\n\t$('#notetable tbody').append('<tr><td><textarea name=\"notes[]\" value=\"\" class=\"form-control\" type=\"text\" placeholder=\"Note\"></textarea></td></tr>');\n\n\t$(\"textarea\").trumbowyg({\n\t    btns: [['bold', 'italic'], ['link'], ['insertImage']]\n\t});\n\n\tif(!datbutton) {\n\t    $('#notetable').append( '<button id=\"addbutton\" type=\"submit\" class=\"btn btn-primary\">Add Notes</button>');\n\t    datbutton = true;\n\t}\n\n    });\n\n    $('.edit-video-btn').on('click', function() {\n\tvar that = this;\n\n\tbootbox.prompt('Enter Video URL', function(result) {\n\t    if(result) {\n\t\t$('#videoinput').val(result);\n\t\t$('#add-video-form').attr('action',\n\t\t\t\t\t  '/setlistitems/' +\n\t\t\t\t\t  $(that).attr('data-item-id') +\n\t\t\t\t\t  '/video');\n\t\t$('#add-video-form').submit();\n\t    }\n\t});\n    });\n\n    $('.delete-video-btn').on('click', function() {\n\tvar that = this;\n\n\tbootbox.confirm('Delete this video?', function(result) {\n\t    if(result) {\n\t\t$('#delete-video-form').attr('action',\n\t\t\t\t\t     '/setlistitems/' +\n\t\t\t\t\t     $(that).attr('data-item-id') +\n\t\t\t\t\t     '/video/' +\n\t\t\t\t\t     $(that).attr('data-video-id'));\n\t\t$('#delete-video-form').submit();\n\t    }\n\t});\n    });\n\n});\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiNi5qcyIsInNvdXJjZXMiOlsid2VicGFjazovLy9yZXNvdXJjZXMvYXNzZXRzL2pzL3Nob3dzaG93cy5qcz8yOGJhIl0sInNvdXJjZXNDb250ZW50IjpbIiQoZG9jdW1lbnQpLnJlYWR5KGZ1bmN0aW9uKCkge1xuXG4gICAgJCgnI2RlbGV0ZS1zaG93LWJ0bicpLm9uKCdjbGljaycsIGZ1bmN0aW9uKCkge1xuXHRib290Ym94LmNvbmZpcm0oJ0FyZSB5b3Ugc3VyZSB5b3Ugd2FudCB0byBkZWxldGUgdGhpcyBzaG93PycsIGZ1bmN0aW9uKHJlc3VsdCkge1xuXHQgICAgaWYocmVzdWx0KSB7XG5cdFx0JCgnI2RlbGV0ZS1zaG93LWZvcm0nKS5zdWJtaXQoKTtcblx0ICAgIH1cblx0fSk7XG5cbiAgICB9KTtcblxuICAgICQoJy5kZWxldGUtc2hvdy1ub3RlLWJ0bicpLm9uKCdjbGljaycsIGZ1bmN0aW9uKCkge1xuXHQkKCcjZGVsZXRlLXNob3ctbm90ZS1mb3JtJykuYXR0cignYWN0aW9uJywgJCgnI2RlbGV0ZS1zaG93LW5vdGUtZm9ybScpLmF0dHIoJ2FjdGlvbicpICsgJCh0aGlzKS5hdHRyKCdkYXRhLW5vdGUtaWQnKSk7XG5cdCQoJyNkZWxldGUtc2hvdy1ub3RlLWZvcm0nKS5zdWJtaXQoKTtcblx0JCgnLmRlbGV0ZS1zaG93LW5vdGUtYnRuJykuYXR0cignZGlzYWJsZWQnLCB0cnVlKTtcbiAgICB9KTtcblxuICAgIGRhdGJ1dHRvbiA9IGZhbHNlO1xuICAgICQoJyNhZGQtc2hvdy1ub3RlLWJ0bicpLmNsaWNrKGZ1bmN0aW9uKCkge1xuXHQkKCcjbm90ZXRhYmxlIHRib2R5JykuYXBwZW5kKCc8dHI+PHRkPjx0ZXh0YXJlYSBuYW1lPVwibm90ZXNbXVwiIHZhbHVlPVwiXCIgY2xhc3M9XCJmb3JtLWNvbnRyb2xcIiB0eXBlPVwidGV4dFwiIHBsYWNlaG9sZGVyPVwiTm90ZVwiPjwvdGV4dGFyZWE+PC90ZD48L3RyPicpO1xuXG5cdCQoXCJ0ZXh0YXJlYVwiKS50cnVtYm93eWcoe1xuXHQgICAgYnRuczogW1snYm9sZCcsICdpdGFsaWMnXSwgWydsaW5rJ10sIFsnaW5zZXJ0SW1hZ2UnXV1cblx0fSk7XG5cblx0aWYoIWRhdGJ1dHRvbikge1xuXHQgICAgJCgnI25vdGV0YWJsZScpLmFwcGVuZCggJzxidXR0b24gaWQ9XCJhZGRidXR0b25cIiB0eXBlPVwic3VibWl0XCIgY2xhc3M9XCJidG4gYnRuLXByaW1hcnlcIj5BZGQgTm90ZXM8L2J1dHRvbj4nKTtcblx0ICAgIGRhdGJ1dHRvbiA9IHRydWU7XG5cdH1cblxuICAgIH0pO1xuXG4gICAgJCgnLmVkaXQtdmlkZW8tYnRuJykub24oJ2NsaWNrJywgZnVuY3Rpb24oKSB7XG5cdHZhciB0aGF0ID0gdGhpcztcblxuXHRib290Ym94LnByb21wdCgnRW50ZXIgVmlkZW8gVVJMJywgZnVuY3Rpb24ocmVzdWx0KSB7XG5cdCAgICBpZihyZXN1bHQpIHtcblx0XHQkKCcjdmlkZW9pbnB1dCcpLnZhbChyZXN1bHQpO1xuXHRcdCQoJyNhZGQtdmlkZW8tZm9ybScpLmF0dHIoJ2FjdGlvbicsXG5cdFx0XHRcdFx0ICAnL3NldGxpc3RpdGVtcy8nICtcblx0XHRcdFx0XHQgICQodGhhdCkuYXR0cignZGF0YS1pdGVtLWlkJykgK1xuXHRcdFx0XHRcdCAgJy92aWRlbycpO1xuXHRcdCQoJyNhZGQtdmlkZW8tZm9ybScpLnN1Ym1pdCgpO1xuXHQgICAgfVxuXHR9KTtcbiAgICB9KTtcblxuICAgICQoJy5kZWxldGUtdmlkZW8tYnRuJykub24oJ2NsaWNrJywgZnVuY3Rpb24oKSB7XG5cdHZhciB0aGF0ID0gdGhpcztcblxuXHRib290Ym94LmNvbmZpcm0oJ0RlbGV0ZSB0aGlzIHZpZGVvPycsIGZ1bmN0aW9uKHJlc3VsdCkge1xuXHQgICAgaWYocmVzdWx0KSB7XG5cdFx0JCgnI2RlbGV0ZS12aWRlby1mb3JtJykuYXR0cignYWN0aW9uJyxcblx0XHRcdFx0XHQgICAgICcvc2V0bGlzdGl0ZW1zLycgK1xuXHRcdFx0XHRcdCAgICAgJCh0aGF0KS5hdHRyKCdkYXRhLWl0ZW0taWQnKSArXG5cdFx0XHRcdFx0ICAgICAnL3ZpZGVvLycgK1xuXHRcdFx0XHRcdCAgICAgJCh0aGF0KS5hdHRyKCdkYXRhLXZpZGVvLWlkJykpO1xuXHRcdCQoJyNkZWxldGUtdmlkZW8tZm9ybScpLnN1Ym1pdCgpO1xuXHQgICAgfVxuXHR9KTtcbiAgICB9KTtcblxufSk7XG5cblxuXG4vLyBXRUJQQUNLIEZPT1RFUiAvL1xuLy8gcmVzb3VyY2VzL2Fzc2V0cy9qcy9zaG93c2hvd3MuanMiXSwibWFwcGluZ3MiOiJBQUFBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTsiLCJzb3VyY2VSb290IjoiIn0=");

/***/ },
/* 7 */
/***/ function(module, exports) {

eval("$(document).ready(function() {\n\n$('#delete-song-btn').on('click', function() {\n    bootbox.confirm('Are you sure you wanted to delete this song?', function(result) {\n\tif(result) {\n\t    $('#delete-song-form').submit();\n\t}\n    });\n});\n\n$('.delete-song-note-btn').on('click', function() {\n    $('#delete-song-note-form').attr('action', $('#delete-song-note-form').attr('action') + $(this).attr('data-note-id'));\n    $('#delete-song-note-form').submit();\n    $('.delete-song-note-btn').attr('disabled', true);\n});\n\n$(document).ready(function() {\n    var datbutton = false;\n    $('#add-song-note-btn').click(function() {\n\t$('#notetable tbody').append('<tr><td><textarea name=\"notes[]\" value=\"\" class=\"form-control\" type=\"text\" placeholder=\"Note\"></textarea></td></tr>');\n\n\t$(\"textarea\").trumbowyg({\n\t    btns: [['bold', 'italic'], ['link'], ['insertImage']]\n\t});\n\n\tif(!datbutton) {\n\t    $('#notetable').append( '<button id=\"add-song-note-btn\" type=\"submit\" class=\"btn btn-primary\">Add Notes</button>');\n\t    datbutton = true;\n\t}\n\n    });\n});\n\n});\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiNy5qcyIsInNvdXJjZXMiOlsid2VicGFjazovLy9yZXNvdXJjZXMvYXNzZXRzL2pzL3Nob3dzb25ncy5qcz82MzYyIl0sInNvdXJjZXNDb250ZW50IjpbIiQoZG9jdW1lbnQpLnJlYWR5KGZ1bmN0aW9uKCkge1xuXG4kKCcjZGVsZXRlLXNvbmctYnRuJykub24oJ2NsaWNrJywgZnVuY3Rpb24oKSB7XG4gICAgYm9vdGJveC5jb25maXJtKCdBcmUgeW91IHN1cmUgeW91IHdhbnRlZCB0byBkZWxldGUgdGhpcyBzb25nPycsIGZ1bmN0aW9uKHJlc3VsdCkge1xuXHRpZihyZXN1bHQpIHtcblx0ICAgICQoJyNkZWxldGUtc29uZy1mb3JtJykuc3VibWl0KCk7XG5cdH1cbiAgICB9KTtcbn0pO1xuXG4kKCcuZGVsZXRlLXNvbmctbm90ZS1idG4nKS5vbignY2xpY2snLCBmdW5jdGlvbigpIHtcbiAgICAkKCcjZGVsZXRlLXNvbmctbm90ZS1mb3JtJykuYXR0cignYWN0aW9uJywgJCgnI2RlbGV0ZS1zb25nLW5vdGUtZm9ybScpLmF0dHIoJ2FjdGlvbicpICsgJCh0aGlzKS5hdHRyKCdkYXRhLW5vdGUtaWQnKSk7XG4gICAgJCgnI2RlbGV0ZS1zb25nLW5vdGUtZm9ybScpLnN1Ym1pdCgpO1xuICAgICQoJy5kZWxldGUtc29uZy1ub3RlLWJ0bicpLmF0dHIoJ2Rpc2FibGVkJywgdHJ1ZSk7XG59KTtcblxuJChkb2N1bWVudCkucmVhZHkoZnVuY3Rpb24oKSB7XG4gICAgdmFyIGRhdGJ1dHRvbiA9IGZhbHNlO1xuICAgICQoJyNhZGQtc29uZy1ub3RlLWJ0bicpLmNsaWNrKGZ1bmN0aW9uKCkge1xuXHQkKCcjbm90ZXRhYmxlIHRib2R5JykuYXBwZW5kKCc8dHI+PHRkPjx0ZXh0YXJlYSBuYW1lPVwibm90ZXNbXVwiIHZhbHVlPVwiXCIgY2xhc3M9XCJmb3JtLWNvbnRyb2xcIiB0eXBlPVwidGV4dFwiIHBsYWNlaG9sZGVyPVwiTm90ZVwiPjwvdGV4dGFyZWE+PC90ZD48L3RyPicpO1xuXG5cdCQoXCJ0ZXh0YXJlYVwiKS50cnVtYm93eWcoe1xuXHQgICAgYnRuczogW1snYm9sZCcsICdpdGFsaWMnXSwgWydsaW5rJ10sIFsnaW5zZXJ0SW1hZ2UnXV1cblx0fSk7XG5cblx0aWYoIWRhdGJ1dHRvbikge1xuXHQgICAgJCgnI25vdGV0YWJsZScpLmFwcGVuZCggJzxidXR0b24gaWQ9XCJhZGQtc29uZy1ub3RlLWJ0blwiIHR5cGU9XCJzdWJtaXRcIiBjbGFzcz1cImJ0biBidG4tcHJpbWFyeVwiPkFkZCBOb3RlczwvYnV0dG9uPicpO1xuXHQgICAgZGF0YnV0dG9uID0gdHJ1ZTtcblx0fVxuXG4gICAgfSk7XG59KTtcblxufSk7XG5cblxuXG4vLyBXRUJQQUNLIEZPT1RFUiAvL1xuLy8gcmVzb3VyY2VzL2Fzc2V0cy9qcy9zaG93c29uZ3MuanMiXSwibWFwcGluZ3MiOiJBQUFBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOyIsInNvdXJjZVJvb3QiOiIifQ==");

/***/ },
/* 8 */
/***/ function(module, exports, __webpack_require__) {

eval("/**\n * First we will load all of this project's JavaScript dependencies which\n * include Vue and Vue Resource. This gives a great starting point for\n * building robust, powerful web applications using Vue and Laravel.\n */\n\n__webpack_require__(0);\n__webpack_require__(1);\n__webpack_require__(2);\n__webpack_require__(3);\n__webpack_require__(5);\n__webpack_require__(6);\n__webpack_require__(7);\n__webpack_require__(4);\n\n\n/**\n * Next, we will create a fresh Vue application instance and attach it to\n * the body of the page. From here, you may begin adding components to\n * the application, or feel free to tweak this setup for your needs.\n */\n/**\n\nVue.component('example', require('./components/Example.vue'));\n\nconst app = new Vue({\n    el: '#app'\n});\n*/\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiOC5qcyIsInNvdXJjZXMiOlsid2VicGFjazovLy9yZXNvdXJjZXMvYXNzZXRzL2pzL2FwcC5qcz84YjY3Il0sInNvdXJjZXNDb250ZW50IjpbIi8qKlxuICogRmlyc3Qgd2Ugd2lsbCBsb2FkIGFsbCBvZiB0aGlzIHByb2plY3QncyBKYXZhU2NyaXB0IGRlcGVuZGVuY2llcyB3aGljaFxuICogaW5jbHVkZSBWdWUgYW5kIFZ1ZSBSZXNvdXJjZS4gVGhpcyBnaXZlcyBhIGdyZWF0IHN0YXJ0aW5nIHBvaW50IGZvclxuICogYnVpbGRpbmcgcm9idXN0LCBwb3dlcmZ1bCB3ZWIgYXBwbGljYXRpb25zIHVzaW5nIFZ1ZSBhbmQgTGFyYXZlbC5cbiAqL1xuXG5yZXF1aXJlKCcuL2FkbWluJyk7XG5yZXF1aXJlKCcuL2VkaXRzaG93Jyk7XG5yZXF1aXJlKCcuL2luZGV4c2hvd3MnKTtcbnJlcXVpcmUoJy4vaW5kZXhzb25ncycpO1xucmVxdWlyZSgnLi9wbGF5c29uZ3MnKTtcbnJlcXVpcmUoJy4vc2hvd3Nob3dzJyk7XG5yZXF1aXJlKCcuL3Nob3dzb25ncycpO1xucmVxdWlyZSgnLi9pbmRleHVzZXJzJyk7XG5cblxuLyoqXG4gKiBOZXh0LCB3ZSB3aWxsIGNyZWF0ZSBhIGZyZXNoIFZ1ZSBhcHBsaWNhdGlvbiBpbnN0YW5jZSBhbmQgYXR0YWNoIGl0IHRvXG4gKiB0aGUgYm9keSBvZiB0aGUgcGFnZS4gRnJvbSBoZXJlLCB5b3UgbWF5IGJlZ2luIGFkZGluZyBjb21wb25lbnRzIHRvXG4gKiB0aGUgYXBwbGljYXRpb24sIG9yIGZlZWwgZnJlZSB0byB0d2VhayB0aGlzIHNldHVwIGZvciB5b3VyIG5lZWRzLlxuICovXG4vKipcblxuVnVlLmNvbXBvbmVudCgnZXhhbXBsZScsIHJlcXVpcmUoJy4vY29tcG9uZW50cy9FeGFtcGxlLnZ1ZScpKTtcblxuY29uc3QgYXBwID0gbmV3IFZ1ZSh7XG4gICAgZWw6ICcjYXBwJ1xufSk7XG4qL1xuXG5cblxuLy8gV0VCUEFDSyBGT09URVIgLy9cbi8vIHJlc291cmNlcy9hc3NldHMvanMvYXBwLmpzIl0sIm1hcHBpbmdzIjoiQUFBQTs7Ozs7O0FBTUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7Ozs7Ozs7Ozs7Ozs7OyIsInNvdXJjZVJvb3QiOiIifQ==");

/***/ }
/******/ ]);