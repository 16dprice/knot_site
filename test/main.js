function submitFormViaAjax(form) {
    console.log(form);
    let formData = $(form).serializeArray();
    console.log(formData);
    console.log(new FormData($("#form")));
}

// $("#form").on('submit', (function (e) {
//     e.preventDefault();
//
//     let formData = new FormData(this);
//     console.log(formData);
    // formData.append('filename', )

    // $.ajax({
    //     url: "index.php",
    //     type: "POST",
    //     data: new FormData(this),
    //     contentType: false,
    //     cache: false,
    //     processData: false,
    //     beforeSend: function () {
    //         //$("#preview").fadeOut();
    //         $("#err").fadeOut();
    //     },
    //     success: function (data) {
    //         if (data == 'invalid') {
    //             // invalid file format.
    //             $("#err").html("Invalid File !").fadeIn();
    //         }
    //         else {
    //             // view uploaded file.
    //             $("#preview").html(data).fadeIn();
    //             $("#form")[0].reset();
    //         }
    //     },
    //     error: function (e) {
    //         $("#err").html(e).fadeIn();
    //     }
    // });
// }));