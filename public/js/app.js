!function(t){var e={};function n(i){if(e[i])return e[i].exports;var o=e[i]={i:i,l:!1,exports:{}};return t[i].call(o.exports,o,o.exports,n),o.l=!0,o.exports}n.m=t,n.c=e,n.d=function(t,e,i){n.o(t,e)||Object.defineProperty(t,e,{enumerable:!0,get:i})},n.r=function(t){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(t,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(t,"__esModule",{value:!0})},n.t=function(t,e){if(1&e&&(t=n(t)),8&e)return t;if(4&e&&"object"==typeof t&&t&&t.__esModule)return t;var i=Object.create(null);if(n.r(i),Object.defineProperty(i,"default",{enumerable:!0,value:t}),2&e&&"string"!=typeof t)for(var o in t)n.d(i,o,function(e){return t[e]}.bind(null,o));return i},n.n=function(t){var e=t&&t.__esModule?function(){return t.default}:function(){return t};return n.d(e,"a",e),e},n.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},n.p="/",n(n.s=0)}([function(t,e,n){n(1),t.exports=n(2)},function(t,e){window.onload=function(){var t="touchstart"in document.documentElement?"touchstart":"click";window.location.hostnameincludes("itchlist.me")&&Sentry.init({dsn:"https://5db4b6559c4048a6bb6128db62e0f8db@sentry.io/1487573"}),axios.interceptors.response.use(function(t){return t},function(t){return 401==t.response.status?(t.response.data.action&&(document.location.href=t.response.data.action),Promise.reject(t)):Promise.reject(t)}),$("#profile-hook").click(function(){$("#profile-dropdown").toggle()}),friendsTemplate=function(t){var e="";return e+="<li>",e+='<a class="friend" href="/'+t.uuid+'">',e+='<img class="friend-pic" src='+t.pic+">",e+='<span class="friend-name">'+t.name+"</span>",e+="</a>",e+="</li>"},renderFriends=function(t,e){var n=t.filter(function(t){return t.name.toLowerCase().includes(e.toLowerCase())}),i="";if(n.forEach(function(t){i+=friendsTemplate(t)}),""==i){var o='<li class="friend"><a href="'+sendDialogEndpoint+'" class="friend-name">Not found, click to invite</span></li>';i=o}$("#friends").html(i)},$("#searchbox").on("focusout",function(){setTimeout(function(){$("#friends").css("display","none"),$("#searchbox-input").val("")},150)}),$("#searchbox-icon").on("click",function(){$("#searchbox-input").trigger("focus"),$(window).width()<650?"0px"==$("#searchbox-input").css("width")?($("#searchbox-input").css("width","155px"),$(".menu-logo-wrapper").css("display","none")):($("#searchbox-input").css("width","0px"),$(".menu-logo-wrapper").css("display","initial")):($("#searchbox-input").css("width","155px"),$(".menu-logo-wrapper").css("display","initial"))});var e=null;$("#searchbox-input").on("keyup",function(){clearTimeout(e),$("#friends").css("display","initial"),$("#friends").html('<li class="friend"><span class="friend-name">Searching...</span></li>'),e=setTimeout(function(){axios.get("/api/friends").then(function(t){renderFriends(t.data,$("#searchbox-input").val())})},500)}),$(".feed-delete").click(function(t){var e=this;if("true"==$(t.target).attr("data-confirm")){$(this).html('<i class="fas fa-circle-notch fa-spin"></i>');var n=$(t.target).attr("data-id");axios.delete("api/itch/"+n).then(function(){var e=$(t.target).closest(".feed-item");e.css("opacity",0),setTimeout(function(){e.remove()},500)})}else $(this).text("Click again to delete"),$(t.target).attr("data-confirm",!0),setTimeout(function(){$(e).text("Delete"),$(t.target).attr("data-confirm",!1)},2e3)}),$("#feed-share").on("click",function(){var t=$("#share-list").attr("data-share"),e=$("<input>");$("body").append(e),e.val(t).select(),document.execCommand("copy"),e.remove(),$("#feed-heading").css("display","none"),$("#feed-heading-copied").css("display","flex"),setTimeout(function(){$("#feed-heading").css("display","flex"),$("#feed-heading-copied").css("display","none")},2e3)}),$("#feed-add").click(function(){$("#list-add").css("display","flex"),$("#list-add-input").focus()}),$("#list-add-button").click(function(){var t=this,e=$("#list-add-input").val();e&&($(this).html(' <i class="fas fa-circle-notch fa-spin"> </i> '),axios.post("api/itch",{"provider-url":e}).then(function(t){location.reload()}).catch(function(e){$(t).html("Invalid url"),setTimeout(function(){$(t).html("Save"),$("#list-add-input").val("")},3e3)}))}),window.cookieconsent.initialise({palette:{popup:{background:"#f26242",text:"#ffffff"},button:{background:"#ffffff",text:"#f26242"}},theme:"edgeless"}),$("#account-delete").on("clickEvent",function(){var t=$("#account-delete"),e=$("#account-delete-input"),n=$("#account-delete-label"),i=t.attr("data-passphrase").trim().toLowerCase();e.val().trim().toLowerCase()!==i?n.css("display","inline"):"true"==t.attr("data-confirm")?(t.html('Deleting <i class="fas fa-circle-notch fa-spin"></i>'),axios.delete("/api/me/account").then(function(){document.location.href="/"})):(t.text("Click again to delete"),t.attr("data-confirm",!0),n.css("display","none"))}),$(".feed-book").on(t,function(t){var e=$(t.currentTarget).attr("data-id");axios.post("/api/itch/"+e+"/book").then(function(t){location.reload()})}),$(".feed-unbook").on(t,function(t){var e=$(t.currentTarget).attr("data-id");axios.post("/api/itch/"+e+"/unbook").then(function(t){location.reload()})}),$(".feed-hide").on(t,function(t){var e=$(t.currentTarget).attr("data-id");axios.post("/api/itch/"+e+"/hide").then(function(t){location.reload()})}),$(".feed-show").on(t,function(t){var e=$(t.currentTarget).attr("data-id");axios.post("/api/itch/"+e+"/show").then(function(t){location.reload()})})}},function(t,e){}]);