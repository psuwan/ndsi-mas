// Upload files
function uploadFiles(name2Up, dir2Up, fileRet) {
    let splitName = name2Up.split('_');
    let totalfiles = document.getElementById(splitName[1] + '_fileID').files.length;

    if (totalfiles > 0) {

        let formData = new FormData();

        // Read selected files
        for (let index = 0; index < totalfiles; index++) {
            formData.append(splitName[1] + '_file[]', document.getElementById(splitName[1] + '_fileID').files[index]);
        }
        formData.append('fileRefNumber', splitName[0]);
        formData.append('fileRefString', splitName[1]);
        formData.append('folder2Upload', dir2Up);

        let xhttp = new XMLHttpRequest();

        // Set POST method and ajax file path
        xhttp.open("POST", "uploadFiles.php", true);

        // call on request changes state
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
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