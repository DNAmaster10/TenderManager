function submitSearch() {
    var searchTerm = document.getElementById("search_input").value;
    var searchTypes = "";
    if (document.getElementById("search_questions").checked) {
        searchTypes = searchTypes + "questions#-#";
    }
    if (document.getElementById("search_tags").checked) {
        searchTypes = searchTypes + "tags#-#";
    }
    if (document.getElementById("search_clients").checked) {
        searchTypes = searchTypes + "clients"
    }
    var tagList = document.getElementById("tag_list").value;
    if (tagList.length < 1) {
        tagList = "false";
    }
    if (!(searchTerm.length < 0 || searchTerm == "" ) && (searchTypes != "")) {
        $.ajax({
            url: "/pages/handle/search_handle.php",
            type: "GET",
            data: {search_term:searchTerm,search_types:searchTypes,tag_list:tagList},
            success: function(data) {
                console.log("data");
            }
        });
    }
}
function getTags() {
    var tagInput = document.getElementById("tag_input").value;
    if (!(tagInput.length < 1)) {
        $.ajax({
            url: "/pages/handle/get_tags.php",
            type: "GET",
            data: {tag:tagInput},
            success: function (data) {
                document.getElementById("tag_container").innerHTML = "";
                var tagArray = data.split("#-#");
                var tagList = document.getElementById("tag_list");
                for (var i = 0; i < tagArray.length; i++) {
                    if (!(tagArray[i].length < 1) && !(tagArray[i] == "null") && !(tagList.includes(tagArray[i]))) {
                        var element = `
                        <button type="button" id="`+tagArray[i]+`_tag" class="tag_select_button" value="`+tagArray[i]+`" onclick="addTag(this.value)">`+tagArray[i]+`</button>
                        `;
                    }
                }
            }
        });
    }
    else {
        document.getElementById("tag_container").innerHTML = "";
    }
}