document.getElementById("search_questions").checked = true;
document.getElementById("search_clients").checked = true;
function submitSearch() {
    console.log("Searching...");
    var searchTerm = document.getElementById("search_input").value;
    var searchTypes = "";
    if (document.getElementById("search_questions").checked) {
        searchTypes = searchTypes + "questions";
    }
    if (document.getElementById("search_clients").checked) {
        searchTypes = searchTypes + "#-#clients"
    }
    var tagList = document.getElementById("tag_list").value;
    if (tagList.length < 1) {
        tagList = "false";
    }
    
    if (!(searchTerm.length < 1 && tagList != "false")) {
        console.log("Passed checks");
        $.ajax({
            url: "/pages/handle/search_handle.php",
            type: "GET",
            data: {search_term:searchTerm,search_types:searchTypes,tag_list:tagList},
            success: function(data) {
                document.getElementById("question_results").innerHTML = "";
                document.getElementById("client_results").innerHTML = "";
                if (data != "error") {
                    console.log(data);
                    var resultsArray = data.split("#-#");
                    for (var i = 0; i < resultsArray.length; i++) {
                        console.log("1");
                        if (resultsArray[i] != "") {
                            var secondResultArray = resultsArray[i].split("@-@");
                            console.log(secondResultArray);
                            if (secondResultArray[0] == "question") {
                                console.log("2")
                                var thirdResultArray = secondResultArray[1].split("-#-");
                                var ratingText = "";
                                var rating = parseInt(thirdResultArray[4]);
                                for (var j = 0; j <= rating; j++) {
                                    ratingText += "★";
                                }
                                for (var j = 0; j < 5 - rating; j++) {
                                    ratingText += "☆";
                                }
                                console.log("rating text: " + rating);
                                var element = `
                                <div id="`+thirdResultArray[0]+`_result_container" class="result_container">
                                    <p id="`+thirdResultArray[0]+`_p" class="result_p">`+thirdResultArray[1]+`</p>
                                    <p id="`+thirdResultArray[0]+`_rating" class="rating_p">`+ratingText+`</p>
                                </div>
                                `;
                                console.log(element);
                                var rootElement = document.getElementById("question_results");
                                rootElement.innerHTML += element;
                            }
                            else if (secondResultArray[0] == "client") {
                                var thirdResultArray = secondResultArray[1].split("-#-");
                                var ratingText = "";
                                var rating = parseInt(thirdResultArray[4]);
                                var rating = parseInt(thirdResultArray[4]);
                                for (var j = 0; j <= rating; j++) {
                                    ratingText += "★";
                                }
                                for (var j = 0; j < 5 - rating; j++) {
                                    ratingText += "☆";
                                }
                                console.log("rating text: " + rating);
                                var element = `
                                <div id="`+thirdResultArray[0]+`_result_container" class="result_container">
                                    <p id="`+thirdResultArray[0]+`_p" class="result_p">`+thirdResultArray[1]+`</p>
                                    <p id="`+thirdResultArray[0]+`_rating" class="rating_p">`+ratingText+`</p>
                                </div>
                                `;
                                var rootElement = document.getElementById("client_results");
                                rootElement.innerHTML += element;
                            }
                        }
                    }
                }
            }
        });
    }
    else {
        document.getElementById("question_results").innerHTML = "";
        document.getElementById("client_results").innerHTML = "";
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
                var tagList = document.getElementById("tag_list").value;
                var rootElement = document.getElementById("tag_container");
                for (var i = 0; i < tagArray.length; i++) {
                    if (!(tagArray[i].length < 1) && !(tagArray[i] == "null") && !(tagList.includes(tagArray[i]))) {
                        var element = `
                        <button type="button" id="`+tagArray[i]+`_tag" class="tag_select_button" value="`+tagArray[i]+`" onclick="addTag(this.value)">`+tagArray[i]+`</button>
                        `;
                        rootElement.innerHTML += element;
                    }
                }
            }
        });
    }
    else {
        document.getElementById("tag_container").innerHTML = "";
    }
}
function addTag(tag) {
    if (tag.length > 0) {
        var tagArray = document.getElementById("tag_list").value;
        if (tagArray.length < 1) {
            document.getElementById("tag_list").value = tag;
            var returnArray = [tag];
        }
        else {
            tagArray = tagArray.split("#-#");
            returnArray = [];
            for (var i = 0; i < tagArray.length; i++) {
                if (!tagArray[i] == "") {
                    returnArray.push(tagArray[i]);
                }
            }
            returnArray.push(tag);
        }
        var returnString = returnArray.join("#-#");
        document.getElementById("tag_list").value = returnString;
        
        var rootElement = document.getElementById("added_tag_container");
        rootElement.innerHTML = "";
        for (var i = 0; i < returnArray.length; i++) {
            var element = `
            <button type="button" value="`+returnArray[i]+`" class="tag_select_button" id="`+returnArray[i]+`_added_tag" onclick="removeTag(this.value)" onmouseover="addX(this.value)" onmouseout="removeX(this.value)">`+returnArray[i]+`</button>
            `;
            rootElement.innerHTML += element;
        }
        document.getElementById("tag_input").value = "";
        document.getElementById("tag_container").innerHTML = "";
        submitSearch();

    }
}
function addX(tagName) {
    document.getElementById(tagName + "_added_tag").innerHTML = tagName + " X";
}
function removeX(tagName) {
    document.getElementById(tagName + "_added_tag").innerHTML = tagName;
}
function removeTag(tagName) {
    tagArray = document.getElementById("tag_list").value;
    tagArray = tagArray.split("#-#");
    returnArray = [];
    for (var i = 0; i < tagArray.length; i++) {
        if (!(tagArray[i] == "") && !(tagArray[i] == tagName)) {
            returnArray.push(tagArray[i]);
        }
    }
    document.getElementById("tag_list").value = returnArray.join("#-#");
    rootElement = document.getElementById("added_tag_container");
    rootElement.innerHTML = "";
    for (var i = 0; i < returnArray.length; i++) {
        var element = `
        <button type="button" value="`+returnArray[i]+`" class="tag_select_button" id="`+returnArray[i]+`_added_tag" onclick="removeTag(this.value)" onmouseover="addX(this.value)" onmouseout="removeX(this.value)">`+returnArray[i]+`</button>
        `;
        rootElement.innerHTML += element;
    }
}