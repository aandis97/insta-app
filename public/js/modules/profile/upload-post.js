
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
                if (response.error) {
                    if (response.error.foto) {
                        $('#image').addClass('is-invalid');
                        $('.error-image').html(response.error.image);
                    } else {
                        $('#image').removeClass('is-invalid');
                        $('.error-image').html('');
                    }

                    return;
                } 
                
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