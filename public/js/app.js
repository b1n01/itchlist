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
  var clickEvent = 'touchstart' in document.documentElement ? 'touchstart' : 'click'; // Config axios

  axios.interceptors.response.use(function (response) {
    return response;
  }, function (error) {
    if (error.response.status == 401) {
      if (error.response.data.action) {
        document.location.href = error.response.data.action;
      }

      return Promise.reject(error);
    }

    return Promise.reject(error);
  }); // Handle dropdown

  $('#profile-hook').click(function () {
    $('#profile-dropdown').toggle();
  }); // Render friends list

  friendsTemplate = function friendsTemplate(friend) {
    var html = '';
    html += '<li>';
    html += '<a class="friend" href="' + '/u/' + friend.uuid + '">';
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
      var inviteFriends = '<li class="friend"><a href="' + sendDialogEndpoint + '" class="friend-name">Not found, click to invite</span></li>';
      friendsHtml = inviteFriends; // injected via php
    }

    $('#friends').html(friendsHtml);
  };

  $("#searchbox").on('focusout', function () {
    setTimeout(function () {
      $('#friends').css('display', 'none');
      $("#searchbox-input").val('');
    }, 150);
  });
  $("#searchbox-icon").on('click', function () {
    $("#searchbox-input").trigger('focus');

    if ($(window).width() < 650) {
      if ($('#searchbox-input').css('width') == '0px') {
        $('#searchbox-input').css('width', '120px');
        $('.menu-logo-wrapper').css('display', 'none');
        $('.searchbox').css('border', '1px solid rgba(0,0,0,.25)');
      } else {
        $('#searchbox-input').css('width', '0px');
        $('.menu-logo-wrapper').css('display', 'initial');
        $('.searchbox').css('border', '1px solid rgba(0,0,0,.0)');
      }
    } else {
      if ($('#searchbox-input').css('width') == '0px') {
        $('#searchbox-input').css('width', '120px');
        $('.menu-logo-wrapper').css('display', 'initial');
        $('.searchbox').css('border', '1px solid rgba(0,0,0,.25)');
      } else {
        $('#searchbox-input').css('width', '0px');
        $('.menu-logo-wrapper').css('display', 'initial');
        $('.searchbox').css('border', '1px solid rgba(0,0,0,.0)');
      }
    }
  }); // Handle searchbox

  var searchTimeout = null;
  $("#searchbox-input").on("keyup", function () {
    clearTimeout(searchTimeout);
    $('#friends').css('display', 'initial');
    $('#friends').html('<li class="friend"><span class="friend-name">Searching...</span></li>');
    searchTimeout = setTimeout(function () {
      axios.get('/api/friends').then(function (response) {
        renderFriends(response.data, $("#searchbox-input").val());
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
  }); // Cookieconsent

  window.cookieconsent.initialise({
    "palette": {
      "popup": {
        "background": "#f26242",
        "text": "#ffffff"
      },
      "button": {
        "background": "#ffffff",
        "text": "#f26242"
      }
    },
    "theme": "edgeless"
  }); // Delete account

  $('#account-delete').on('clickEvent', function () {
    var button = $('#account-delete');
    var input = $('#account-delete-input');
    var label = $('#account-delete-label');
    var passphrase = button.attr('data-passphrase').trim().toLowerCase();
    var inputText = input.val().trim().toLowerCase();

    if (inputText !== passphrase) {
      label.css('display', 'inline');
    } else {
      if (button.attr('data-confirm') == 'true') {
        button.html('Deleting <i class="fas fa-circle-notch fa-spin"></i>');
        axios["delete"]('/api/me/account').then(function () {
          document.location.href = '/';
        });
      } else {
        button.text('Click again to delete');
        button.attr('data-confirm', true);
        label.css('display', 'none');
      }
    }
  }); // Book an Itch

  $('.feed-book').on(clickEvent, function (e) {
    var itchId = $(e.currentTarget).attr('data-id');
    axios.post('/api/itch/' + itchId + '/book').then(function (response) {
      location.reload();
    });
  }); // Unbook an Itch

  $('.feed-unbook').on(clickEvent, function (e) {
    var itchId = $(e.currentTarget).attr('data-id');
    axios.post('/api/itch/' + itchId + '/unbook').then(function (response) {
      location.reload();
    });
  }); // Hide an Itch

  $('.feed-hide').on(clickEvent, function (e) {
    var itchId = $(e.currentTarget).attr('data-id');
    axios.post('/api/itch/' + itchId + '/hide').then(function (response) {
      location.reload();
    });
  }); // Show an Itch

  $('.feed-show').on(clickEvent, function (e) {
    var itchId = $(e.currentTarget).attr('data-id');
    axios.post('/api/itch/' + itchId + '/show').then(function (response) {
      location.reload();
    });
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