function getTags() {
    //Gets all tags from database and puts them onto tags page 
    $.ajax({
        url: "/pages/handle/get_all_tags.php",
        type: "GET",
        success: function (data) {
            console.log(data);
        }
    });
}
getTags();