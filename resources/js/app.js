window.onload = function () 
{
    const clickEvent =  'touchstart' in document.documentElement ? 'touchstart' : 'click';
    
    // Config axios
    axios.interceptors.response.use(function (response) {
        return response
    }, function (error) {
        if(error.response.status == 401 ) {
            if (error.response.data.action) {
                document.location.href = error.response.data.action
            }
            return Promise.reject(error)
        }
        return Promise.reject(error)
    })

    // Handle dropdown
    $('#profile-hook').click(function() {
        $('#profile-dropdown').toggle()
    })

    // Render friends list
    friendsTemplate = function(friend) {
        var html = ''
        html += '<li>'
        html += '<a class="friend" href="' + '/' + friend.uuid +'">'
        html += '<img class="friend-pic" src=' + friend.pic + '>'
        html += '<span class="friend-name">' + friend.name + '</span>'
        html += '</a>'
        html += '</li>'
        return html 
    }

    renderFriends = function(friends, search) {
        let filteredFriends = friends.filter(function(friend) {
            return friend.name.toLowerCase().includes(search.toLowerCase())
        })

        let friendsHtml = ''
        filteredFriends.forEach(function(friend) {
            friendsHtml += friendsTemplate(friend)
        })

        if(friendsHtml == ''){
            friendsHtml = '<li class="friend"><span class="friend-name">No results found</span></li>'
        }
        $('#frieds').html(friendsHtml)
    }

    $("#searchbox").on('focusout', function() {
        setTimeout(function() {
            $('#frieds').css('display', 'none')
            $("#searchbox-input").val('')
        }, 150)
    })

    $("#searchbox-icon").on('click', function() {
        $("#searchbox-input").trigger('focus')        
        if($(window).width() < 650) {
            if($('#searchbox-input').css('width') == '0px') {
                $('#searchbox-input').css('width', '155px')    
                $('.menu-logo-wrapper').css('display', 'none')
            } else {
                $('#searchbox-input').css('width', '0px')
                $('.menu-logo-wrapper').css('display', 'initial')
            }
        } else {
            $('#searchbox-input').css('width', '155px')    
            $('.menu-logo-wrapper').css('display', 'initial')
        }
    })

    // Handle searchbox
    let searchTimeout = null
    $("#searchbox-input").on("keyup", function() {
        clearTimeout(searchTimeout)
        $('#frieds').css('display', 'initial')
        $('#frieds').html('<li class="friend"><span class="friend-name">Searching...</span></li>')

        searchTimeout = setTimeout(function() {
            axios.get('/api/friends')
                .then(function (response) {
                    let friends = response.data
                    renderFriends(friends, $("#searchbox-input").val())
                })
                .catch(function (error) {
                    //console.log(error) //handeld by default axios config
                })
        }, 500)
    })

    // Item actions
    $('.feed-delete').click(function(e) {
        var confirmed = $(e.target).attr('data-confirm')
        if(confirmed == 'true') {
            $(this).html('<i class="fas fa-circle-notch fa-spin"></i>')
            var id = $(e.target).attr('data-id')
            axios.delete('api/itch/' + id)
                .then(function() {
                    var item = $(e.target).closest('.feed-item')
                    item.css('opacity', 0)
                    setTimeout(() => { item.remove() }, 500)               
            })
        } else {
            $(this).text('Click again to delete')
            $(e.target).attr('data-confirm', true)
            setTimeout(() => { 
                $(this).text('Delete')
                $(e.target).attr('data-confirm', false)
            }, 2000)    
        }
    })

    // Share list
    $('#feed-share').on('click', function() {

        // copy link to clipboard
        var url = $('#share-list').attr('data-share')
        var $temp = $("<input>")
        $("body").append($temp)
        $temp.val(url).select()
        document.execCommand("copy")
        $temp.remove()

        // Show copied confirmation
        $('#feed-heading').css('display', 'none')
        $('#feed-heading-copied').css('display', 'flex')
        setTimeout(() => { 
            $('#feed-heading').css('display', 'flex')
            $('#feed-heading-copied').css('display', 'none')
        }, 2000)
    })

    // Add to list
    $('#feed-add').click(function() {
        $('#list-add').css('display', 'flex')
        $('#list-add-input').focus()
    })

    $('#list-add-button').click(function() {
        var url = $('#list-add-input').val()

        if(url) {
            $(this).html(' <i class="fas fa-circle-notch fa-spin"> </i> ')
            axios.post('api/itch', {
                'provider-url': url
            }).then(function(response) {
                location.reload()
            }).catch((response) => {
                $(this).html('Invalid url')
                setTimeout(() => { 
                    $(this).html('Save')
                    $('#list-add-input').val('')
                }, 3000)
            })
        }
    })

    // Cookieconsent
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
    })

    // Delete account
    $('#account-delete').on('clickEvent', function () {
        var button = $('#account-delete')
        var input = $('#account-delete-input')
        var label = $('#account-delete-label')

        var passphrase = button.attr('data-passphrase').trim().toLowerCase()
        var inputText = input.val().trim().toLowerCase()

        if(inputText !== passphrase) {
            label.css('display', 'inline')
        } else {
            if(button.attr('data-confirm') == 'true') {
                button.html('Deleting <i class="fas fa-circle-notch fa-spin"></i>')
                axios.delete('/api/me/account').then(function() { document.location.href = '/'})
            } else {
                button.text('Click again to delete')
                button.attr('data-confirm', true)
                label.css('display', 'none')
            }
        }
    })

    // Book an Itch
    $('.feed-book').on(clickEvent, function (e) {
        var itchId = $(e.currentTarget).attr('data-id')
        axios.post('/api/itch/' + itchId + '/book').then(function (response) { location.reload() })
    }) 

    // Unbook an Itch
    $('.feed-unbook').on(clickEvent, function (e) {
        var itchId = $(e.currentTarget).attr('data-id')
        axios.post('/api/itch/' + itchId + '/unbook').then(function (response) { location.reload() })
    }) 

    // Hide an Itch
    $('.feed-hide').on(clickEvent, function (e) {
        var itchId = $(e.currentTarget).attr('data-id')
        axios.post('/api/itch/' + itchId + '/hide').then(function (response) { location.reload() })
    }) 

    // Show an Itch
    $('.feed-show').on(clickEvent, function (e) {
        var itchId = $(e.currentTarget).attr('data-id')
        axios.post('/api/itch/' + itchId + '/show').then(function (response) { location.reload() })
    }) 
}