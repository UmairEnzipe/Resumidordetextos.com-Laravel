$(document).ready(function () {
    init_tinymce();
});

function init_tinymce() {
    tinymce.init({
        selector: ".tool_textarea",
        element_format: "html",
        menubar: true,
        autoresize_bottom_margin: 5,
        relative_urls: true,
        convert_urls: false,
        paste_as_text: true,
        setup: function (editor) {
            editor.on("blur", function () {
                $(editor.container).removeClass("show-menubar");
            });
            editor.on("click", function (e) {
                $(editor.container).addClass("show-menubar");
            });
            editor.ui.registry.addButton("gallaryButton", {
                text: "Gallary",
                tooltip: "Open Gallary",
                onAction: function () {
                    $("#gallaryModalBtn").click();
                },
            });
        },
        plugins: [
            "advlist autolink lists link image charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table paste code help wordcount autoresize",
        ],
        toolbar:
            " formatselect | " +
            "alignleft aligncenter" +
            "alignright alignjustify | bullist numlist outdent indent | " +
            "removeformat | help | gallaryButton",
        content_style:
            "body { font-family:Helvetica,Arial,sans-serif; font-size:14px;}",
    });
}
function stripHtml(html) {
    return (html = html.replace(/\'/gm, "&apos;"));
}
