window.onload = function () 
{
    // Handle dropdown
    $('#profile-hook').click(function() {
        $('#profile-dropdown').toggle()
    })

    // Render friends list
    friendsTemplate = function(friend) {
        var html = '';
        html += '<li>'
        html += '<a class="friend" href="' + '/' + friend.uuid +'">';
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

        let friendsHtml = '';
        filteredFriends.forEach(function(friend) {
            friendsHtml += friendsTemplate(friend)
        })

        if(friendsHtml == ''){
            friendsHtml = '<li class="friend"><span class="friend-name">No results. Invite you friend</span></li>';
        }
        $('#frieds').html(friendsHtml)
    }

    $("#searchbox").on('focusout', function() {
        setTimeout(function() {
            $('#frieds').css('display', 'none')
            $("#searchbox-input").val('')
        }, 150);
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
    });

    // Handle searchbox
    let searchTimeout = null;
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
                    console.log(error)
                });
        }, 500)
    })

    // Item actions
    $('.feed-delete').click(function(e) {
        var confirmed = $(e.target).attr('data-confirm')
        if(confirmed == 'true') {
            $(this).html('<i class="fas fa-circle-notch fa-spin"></i>');
            var id = $(e.target).attr('data-id')
            axios.delete('api/itch/' + id)
                .then(function() {
                    var item = $(e.target).closest('.feed-item')
                    item.css('opacity', 0)
                    setTimeout(() => { item.remove() }, 500)               
            })
        } else {
            $(this).text('Click again to delete');
            $(e.target).attr('data-confirm', true)
            setTimeout(() => { 
                $(this).text('Delete');
                $(e.target).attr('data-confirm', false)
            }, 2000)    
        }
    })

    // Share list
    $('#feed-share').on('click', function() {

        // copy link to clipboard
        var url = $('#share-list').attr('data-share')
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val(url).select();
        document.execCommand("copy");
        $temp.remove();

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
            $(this).html(' <i class="fas fa-circle-notch fa-spin"> </i> ');
            axios.post('api/itch', {
                'provider-url': url
            }).then(function(response) {
                location.reload()
            }).catch((response) => {
                $(this).html('Invalid url');
                setTimeout(() => { 
                    $(this).html('Save')
                    $('#list-add-input').val('')
                }, 3000)
            })
        }
    })
}