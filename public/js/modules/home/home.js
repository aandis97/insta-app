loadPost();

function loadPost() {
    $.ajax({
        type: "GET",
        headers: { 
            'Content-Type' : 'application/json',
        },
        url: `${baseURL}/home/getPostsJson`,
        data: {
            page          : 1,
            per_page      : 10,
        },
        success: function (response) { 
            const posts = response.data;

            const post_template = $("#home_page_post_template_item").clone()[0].innerHTML;
            const comment_template = $("#post_comment_template").clone()[0].innerHTML;
            $.each(posts, function(index, post){
                let post_item = post_template;
                post_item = post_item.replace(/__post_id__/g, post.id); 
                post_item = post_item.replace(/__like_type__/g, post.is_liked_by_me ? 'unlike' : 'like'); 
                post_item = post_item.replace(/__username__/g, post.user_username); 
                post_item = post_item.replace(/__total_likes__/g, post.total_likes); 
                post_item = post_item.replace(/__created_at__/g, post.created_at); 
                post_item = post_item.replace(/__description__/g, post.description); 
                post_item = post_item.replace(/__image__/g, post.image);                
                
                let comments = '';
                $.each(post.comments, function(index, comment){
                    let comment_item = comment_template;
                    comment_item = comment_item.replace(/__username__/g, comment.user_username); 
                    comment_item = comment_item.replace(/__comment__/g, comment.comment); 
                    comments += comment_item;
                });

                post_item = post_item.replace(/__comment_list__/g, comments);

                $(".posts-container").append(post_item);
                
                if (post.is_liked_by_me) {
                    $('.love-icon' + post.id).removeClass("far").addClass("fas").css("color", "red");
                }
            });
        },
        error: function (jqXHR, err) {
            // notif error here : TO DO
        }
    });
}

function like(e) {
    let id = $(e).data('id');
    let type = $(e).data('type');

    $.ajax({
        headers: { 
            'Content-Type' : 'application/json',
        },
        type: "GET",
        url: `${baseURL}home/doLikePost/${id}`,
        data: {
            id: id,
            type: type
        },
        dataType: 'JSON',
    }).done(function (response) {
        if (response.data.type == 'unlike') {
            $('.love-icon' + id).removeClass("fas").addClass("far").css("color", "");
            $(e).data('type', 'like');
        } else {
            $('.love-icon' + id).removeClass("far").addClass("fas").css("color", "red");
            $(e).data('type', 'unlike');
        }
    }).fail(function (jqXHR, textStatus, errorThrown) {
        let res = jqXHR.responseJSON;
        // TO DO if Errir
    });
}


function doComment(post_id) {
    let comment = $(".comment-input-"+post_id).val();
    loading('comment', post_id, true);
    $.ajax({
        headers: { 
            'Content-Type' : 'application/json',
        },
        type: "GET",
        url: `${baseURL}home/doComment/${post_id}`,
        data: {
            comment: comment,
        },
        dataType: 'JSON',
    }).done(function (response) {
        $(".comment-input-"+post_id).val('');
        loading('comment', post_id, false);

        
        let comment_item = $("#post_comment_template").clone()[0].innerHTML;
        comment_item = comment_item.replace(/__username__/g, response.data.username); 
        comment_item = comment_item.replace(/__comment__/g, comment); 
        $(".comment-container-"+post_id).append(comment_item);
    }).fail(function (jqXHR, textStatus, errorThrown) {
        let res = jqXHR.responseJSON;
        // TO DO if Errir
    });
}

function loading(prefix, id, is_loading = false) {
    $(`.${prefix}-input-${id}`).attr('disabled', is_loading);
    $(`.${prefix}-button-${id}`).attr('disabled', is_loading);
}