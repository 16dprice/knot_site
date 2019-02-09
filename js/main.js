function openTab(entryConst) {

    let filename = "./ajax/change_tab.ajax.php";
    console.log(entryConst);

    $.ajax({
        'url': 'index.php',
        'type': 'POST',
        'data': {
            entryConst: entryConst,
            file: filename,
            AJAX: true
        },
        success : function(data) {
            console.log(data);

            window.location.reload();
        },
        error : function(request, error) {

        }
    });

}

function uploadPDcodeToSimplify() {

    // get the input element that has the file on it
    let fileInput = $('#pd_code_file_upload_input')[0];

    // get the file and init a reader
    let file = fileInput.files[0];
    let reader = new FileReader();

    // set the reader onload so that it gets the contents of the text file and sends them to an array which
    // is then sent to the server side
    reader.onload = function(e) {

        let fileText = e.target.result.split("\n");

        let i, pdInput = {};
        pdInput.count = fileText[0];
        for(i = 1; i < fileText.length; i++) {
            pdInput[i - 1] = fileText[i];
        }

        console.log(pdInput);
        let filename = "./ajax/simplify_pd.ajax.php";

        $.ajax({
            'url': 'index.php',
            'type': 'POST',
            'data': {
                pdInput: JSON.stringify(pdInput),
                file: filename,
                AJAX: true
            },
            success : function(data) {
                let jData = JSON.parse(data);
                console.log(jData);

                $('#inputFileContainer').html(jData['inputContainer']);
                $('#outputFileContainer').html(jData['outputContainer']);

            },
            error : function(request, error) {

            }
        });

    };

    reader.readAsText(file, "UTF-8");

}

function uploadMinimalDiagramsRecord() {

    // get the input element that has the knottype on it
    let knotType = $('#minimal_diagrams_knot_type_input').val();

    // get the input element that has the file on it
    let fileInput = $('#minimal_diagrams_file_upload_input')[0];

    // get the file and init a reader
    let file = fileInput.files[0];
    let reader = new FileReader();

    // set the reader onload so that it gets the contents of the text file and sends them to an array which
    // is then sent to the server side along with the knot type
    reader.onload = function(e) {

        let fileText = e.target.result.split("\n");

        let i, pdInput = {};
        pdInput.count = fileText[0];
        for(i = 1; i < fileText.length; i++) {
            pdInput[i - 1] = fileText[i];
        }

        console.log(pdInput);
        let filename = "./ajax/upload_minimal_diagrams_record.ajax.php";

        $.ajax({
            'url': 'index.php',
            'type': 'POST',
            'data': {
                knotType: knotType,
                pdInput: JSON.stringify(pdInput),
                file: filename,
                AJAX: true
            },
            success : function(data) {
                let jData = JSON.parse(data);
                console.log(jData);

                window.location.reload();
            },
            error : function(request, error) {

            }
        });

    };

    reader.readAsText(file, "UTF-8");

}