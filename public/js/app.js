/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/app.js":
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
/*! no static exports found */
/***/ (function(module, exports) {

window.onload = function () {
  // Handle dropdown
  $('#profile-hook').click(function () {
    $('#profile-dropdown').toggle();
  }); // Render friends list

  friendsTemplate = function friendsTemplate(friend) {
    var html = '';
    html += '<li>';
    html += '<a class="friend" href="' + '/' + friend.uuid + '">';
    html += '<img class="friend-pic" src=' + friend.pic + '>';
    html += '<span class="friend-name">' + friend.name + '</span>';
    html += '</a>';
    html += '</li>';
    return html;
  };

  renderFriends = function renderFriends(friends, search) {
    var filteredFriends = friends.filter(function (friend) {
      return friend.name.toLowerCase().includes(search.toLowerCase());
    });
    var friendsHtml = '';
    filteredFriends.forEach(function (friend) {
      friendsHtml += friendsTemplate(friend);
    });

    if (friendsHtml == '') {
      friendsHtml = '<li class="friend"><span class="friend-name">No results. Invite you friend</span></li>';
    }

    $('#frieds').html(friendsHtml);
  };

  $("#searchbox").on('focusout', function () {
    setTimeout(function () {
      $('#frieds').css('display', 'none');
      $("#searchbox-input").val('');
    }, 150);
  });
  $("#searchbox-icon").on('click', function () {
    $("#searchbox-input").trigger('focus');

    if ($(window).width() < 650) {
      if ($('#searchbox-input').css('width') == '0px') {
        $('#searchbox-input').css('width', '155px');
        $('.menu-logo-wrapper').css('display', 'none');
      } else {
        $('#searchbox-input').css('width', '0px');
        $('.menu-logo-wrapper').css('display', 'initial');
      }
    } else {
      $('#searchbox-input').css('width', '155px');
      $('.menu-logo-wrapper').css('display', 'initial');
    }
  }); // Handle searchbox

  var searchTimeout = null;
  $("#searchbox-input").on("keyup", function () {
    clearTimeout(searchTimeout);
    $('#frieds').css('display', 'initial');
    $('#frieds').html('<li class="friend"><span class="friend-name">Searching...</span></li>');
    searchTimeout = setTimeout(function () {
      axios.get('/api/friends').then(function (response) {
        var friends = response.data;
        renderFriends(friends, $("#searchbox-input").val());
      })["catch"](function (error) {
        console.log(error);
      });
    }, 500);
  }); // Item actions

  $('.feed-delete').click(function (e) {
    var _this = this;

    var confirmed = $(e.target).attr('data-confirm');

    if (confirmed == 'true') {
      $(this).html('<i class="fas fa-circle-notch fa-spin"></i>');
      var id = $(e.target).attr('data-id');
      axios["delete"]('api/itch/' + id).then(function () {
        var item = $(e.target).closest('.feed-item');
        item.css('opacity', 0);
        setTimeout(function () {
          item.remove();
        }, 500);
      });
    } else {
      $(this).text('Click again to delete');
      $(e.target).attr('data-confirm', true);
      setTimeout(function () {
        $(_this).text('Delete');
        $(e.target).attr('data-confirm', false);
      }, 2000);
    }
  }); // Share list

  $('#feed-share').on('click', function () {
    // copy link to clipboard
    var url = $('#share-list').attr('data-share');
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val(url).select();
    document.execCommand("copy");
    $temp.remove(); // Show copied confirmation

    $('#feed-heading').css('display', 'none');
    $('#feed-heading-copied').css('display', 'flex');
    setTimeout(function () {
      $('#feed-heading').css('display', 'flex');
      $('#feed-heading-copied').css('display', 'none');
    }, 2000);
  }); // Add to list

  $('#feed-add').click(function () {
    $('#list-add').css('display', 'flex');
    $('#list-add-input').focus();
  });
  $('#list-add-button').click(function () {
    var _this2 = this;

    var url = $('#list-add-input').val();

    if (url) {
      $(this).html(' <i class="fas fa-circle-notch fa-spin"> </i> ');
      axios.post('api/itch', {
        'provider-url': url
      }).then(function (response) {
        location.reload();
      })["catch"](function (response) {
        $(_this2).html('Invalid url');
        setTimeout(function () {
          $(_this2).html('Save');
          $('#list-add-input').val('');
        }, 3000);
      });
    }
  });
};

/***/ }),

/***/ "./resources/sass/app.scss":
/*!*********************************!*\
  !*** ./resources/sass/app.scss ***!
  \*********************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 0:
/*!*************************************************************!*\
  !*** multi ./resources/js/app.js ./resources/sass/app.scss ***!
  \*************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! /Users/llorenzini/Develop/OM/itchlist/resources/js/app.js */"./resources/js/app.js");
module.exports = __webpack_require__(/*! /Users/llorenzini/Develop/OM/itchlist/resources/sass/app.scss */"./resources/sass/app.scss");


/***/ })

/******/ });