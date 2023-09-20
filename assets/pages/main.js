
$("#logout").click(function () {
    AjaxMethod({"action":"logout"},function () {
        document.location="index.php";
    });
});