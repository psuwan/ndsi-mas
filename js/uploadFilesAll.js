// Upload files
function uploadFilesAll(name2Up, dir2Up, fileRet) {
    console.log(name2Up);
    console.log(dir2Up);
    console.log(fileRet);

    let totalfiles = document.getElementById("id4Files_" + name2Up).files.length;
    // console.log(totalfiles);

    if (totalfiles > 0) {

        let formData = new FormData();

        // Read selected files
        for (let index = 0; index < totalfiles; index++) {
            formData.append('Files_' + name2Up + '[]', document.getElementById("id4Files_" + name2Up).files[index]);
        }
        formData.append('fileRefNumber', name2Up);
        // formData.append('fileRefString', splitName[1]);
        formData.append('folder2Upload', dir2Up);

        let xhttp = new XMLHttpRequest();

        // Set POST method and ajax file path
        xhttp.open("POST", "uploadFilesAll.php", true);

        // call on request changes state
        xhttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                let response = this.responseText;           // OK don't delete

                alert('นำเข้าไฟล์ : ' + response + ' ไฟล์');      // OK don't delete
                window.location.href = fileRet;
            }
        };

        // Send request with data
        xhttp.send(formData);

    } else {
        alert("ยังไม่ได้ทำการเลือกไฟล์");
    }
}