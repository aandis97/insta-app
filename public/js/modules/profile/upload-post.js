
function previewImg() {
    const image = document.querySelector('#image');
    const imgPreview = document.querySelector('.img-preview');

    const fileImage = new FileReader();
    fileImage.readAsDataURL(image.files[0]);

    fileImage.onload = function(e) {
        imgPreview.src = e.target.result;
    }
}

$(document).ready(function() {
    loadPost();

    $('#btn-submit-post').click(function(e) {
        e.preventDefault();
        let form = $('#form-upload')[0];
        let data = new FormData(form);

        $.ajax({
            type: "POST",            
            url: `${baseURL}/profile/uploadPost`,
            data: data,
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            cache: false,
            dataType: "json",
            beforeSend: function() {
                $('#btn-submit-post').attr('disable', 'disable');
                $('#btn-submit-post').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> <i>Loading...</i>');
            },
            complete: function() {
                $('#btn-submit-post').removeAttr('disable', 'disable');
                $('#btn-submit-post').html('Post');
            },
            success: function(response) {
                $('#addNewPost').modal('hide');
                
                new PNotify({
                    title: "Success",
                    text: 'Post Uploaded',
                    type: 'success',
                    delay: 1000
                });
            },
            error: function(xhr, ajaxOptions, thrownError) {
                new PNotify({
                    title: "Error",
                    text: xhr.responseJSON.message,
                    type: 'error',
                    delay: 1000
                });
            }
        });

    });
});

function loadPost() {
    $.ajax({
        type: "GET",
        headers: { 
            'Content-Type' : 'application/json',
        },
        url: `${baseURL}/home/getPostsJson/`,
        data: {
            username : username,
        },
        success: function (response) { 
            const posts = response.data;
            $("#total-post").html(posts.length);
            $(".posts-container").empty();
            $.each(posts, function(index, post){
                let post_item = `<div class="col-md-4" onclick="showDetailPost(${post.id})">
                    <button style="background-color:transparent;border:none;"><img class="img-thumbnail" src="${baseURL}/img/posts/${post.image}"></button>
                </div>`
                $(".posts-container").append(post_item);
            });
        },
        error: function (jqXHR, err) {
            // notif error here : TO DO
        }
    });
}

function showDetailPost(post_id)
{
    $('#detail-post').modal('show');
}