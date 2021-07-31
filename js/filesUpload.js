// Upload files
function uploadFiles(refNumber) {
    let totalfiles = document.getElementById('id4FilesEvidence_' + refNumber).files.length;

    if (totalfiles > 0) {

        let formData = new FormData();

        // Read selected files
        for (let index = 0; index < totalfiles; index++) {
            formData.append('filesEvidence_' + refNumber + '[]', document.getElementById('id4FilesEvidence_' + refNumber).files[index]);
        }
        formData.append('docRefNumber', refNumber);
        formData.append('folder2Upload', 'filesEvidence');
        // formData.append('folder2Upload', fileType);

        let xhttp = new XMLHttpRequest();

        // Set POST method and ajax file path
        xhttp.open("POST", "filesUpload.php", true);

        // call on request changes state
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                let response = this.responseText;           // OK don't delete
                let chkHash = refNumber.substring(0, 11);   // Test
                console.log('refNumber: ' + refNumber);     // Test
                console.log('chkhash: ' + chkHash);         // Test

                alert('นำเข้าไฟล์ : ' + response + ' ไฟล์\nrefnumber: ' + refNumber);      // OK don't delete
                window.location.href = 'unitCourseQA.php?courseRefnum=' + refNumber.substring(11, 28) + '&#divReturn_' + chkHash;
                // courseRefnum=20019256525640001&#divReturn_20019050103

                //alert(response + " File(s) uploaded.");
                //document.getElementById('numAttach').innerHTML = response;
                //window.location.reload();
                //document.getElementById('sp_attach').innerHTML = spContent;
                // $('.count-attachment').html(response);
                //history.back();
                //window.location.href = 'fileDocAdd.php';
            }
        };

        // Send request with data
        xhttp.send(formData);

    } else {
        alert("ยังไม่ได้ทำการเลือกไฟล์");
    }
}