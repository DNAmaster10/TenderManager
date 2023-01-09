function getTags() {
    //Gets all tags from database and puts them onto tags page 
    $.ajax({
        url: "/pages/handle/get_all_tags.php",
        type: "GET",
        success: function (data) {
            console.log("GetTags: " + data)
            if (data != "null") {
                var tagArray = data.split("#-#");
                console.log(tagArray);
                for (var i = 0; i < tagArray.length; i++) {
                    if (!(tagArray[i] == "")) {
                        console.log("test");
                        var element = `
                        <div id="` + tagArray[i] + `_tag_container" class="tag_container">
                            <p id="` + tagArray[i] + `_tag" class="tag_text"></p>
                        </div>
                        `;
                        var rootElement = document.getElementById("tag_list_container");
                        rootElement.innerHTML += element;
                    }
                }
            }
        }
    });
}
function addTag() {
    //Adds a tag
    tagName = document.getElementById("tag_name_input").value;
    document.getElementById("tag_name_input").disabled = true;
    document.getElementById("tag_name_submit").disabled = true;
    if (tagName.length < 1) {
        document.getElementById("error").innerHTML = "Please enter a tag name";
        document.getElementById("tag_name_input").disabled = false;
        document.getElementById("tag_name_submit").disabled = false;
    }
    else if (tagName.includes("#-#")) {
        document.getElementById("error").innerHTML = "Tag names cannot include '#-#'";
        document.getElementById("tag_name_input").disabled = false;
        document.getElementById("tag_name_submit").disabled = false;
    }
    else {
        $.ajax({
            url: "/pages/handle/add_tag.php",
            type: "POST",
            data: {tag_name:tagName},
            success: function(data) {
                console.log(data);
                if (!data == "success") {
                    data.split(":")
                    document.getElementById("error").innerHTML = data[1];
                    document.getElementById("tag_name_input").disabled = false;
                    document.getElementById("tag_name_submit").disabled = false;
                }
                else {
                    document.getElementById("tag_name_input").value = "";
                    document.getElementById("tag_name_input").disabled = false;
                    document.getElementById("tag_name_submit").disabled = false;
                    getTags();
                }
            }
        });
    }
}
getTags();