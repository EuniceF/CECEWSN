// https://stackoverflow.com/questions/15965651/progress-bar-while-uploading-large-files-with-xmlhttprequest

/*File chunking
    - https://developer.mozilla.org/en-US/docs/Web/API/Blob/slice
    - https://stackoverflow.com/questions/45046175/splice-upload-and-re-combine-file-blobs
    - https://medium.com/typecode/a-strategy-for-handling-multiple-file-uploads-using-javascript-eb00a77e15f
    - https://stackoverflow.com/questions/15965651/progress-bar-while-uploading-large-files-with-xmlhttprequest
    - https://stackoverflow.com/questions/14438187/javascript-filereader-parsing-long-file-in-chunks
    - https://wicg.github.io/entries-api/

    */
/*var upload =
{
    pageName: '',
    bytesPerChunk: 20 * 1024 * 1024,
    loaded: 0,
    total: 0,
    file: null,
    fileName: "",

    uploadFile: function () {
        var size = upload.file.size;

        if (upload.loaded > size) return;

        var end = upload.loaded + upload.bytesPerChunk;
        if (end > size) { end = size; }

        var blob = upload.file.slice(upload.loaded, end);

        var xhr = new XMLHttpRequest();

        xhr.open('POST', upload.pageName, false);

        xhr.setRequestHeader("Content-Type", "multipart/form-data");
        xhr.setRequestHeader("X-File-Name", upload.fileName);
        xhr.setRequestHeader("X-File-Type", upload.file.type);

        xhr.send(blob);

        upload.loaded += upload.bytesPerChunk;

        setTimeout(upload.updateProgress, 100);
        setTimeout(upload.uploadFile, 100);
    },
    upload: function (file) {
        upload.file = file;

        var date = new Date();
        upload.fileName = date.format("dd.MM.yyyy_HH.mm.ss") + "_" + file.name;

        upload.loaded = 0;
        upload.total = file.size;

        setTimeout(upload.uploadFile, 100);


        return upload.fileName;
    },
    updateProgress: function () {
        var progress = Math.ceil(((upload.loaded) / upload.total) * 100);
        if (progress > 100) progress = 100;

        $("#dvProgressPrcent").html(progress + "%");
        $get('dvProgress').style.width = progress + '%';
    }
};


// https://stackoverflow.com/questions/3352555/xhr-upload-progress-is-100-from-the-start
xhr.upload.onprogress = function(evt)
{
    if (evt.lengthComputable)
    {
        var percentComplete = parseInt((evt.loaded / evt.total) * 100);
        console.log("Upload: " + percentComplete + "% complete")
    }
};*/