document.getElementById("search_questions").checked = true;
document.getElementById("search_clients").checked = true;
function submitSearch() {
    document.getElementById("question_ammount").value = "0";
    document.getElementById("client_ammount").value = "0";
    var questionAmmount = 0;
    var clientAmmount = 0;
    var searchTerm = document.getElementById("search_input").value;
    if (searchTerm.length < 1) {
        document.cookie = "lastSearchTerm=none";
    }
    else {
        document.cookie = "lastSearchTerm=" + searchTerm;
    }
    var searchTypesArray = [];
    if (document.getElementById("search_questions").checked) {
        searchTypesArray.push("questions");
    }
    if (document.getElementById("search_clients").checked) {
        searchTypesArray.push("clients");
    }
    var searchTypes = searchTypesArray.join("#-#");
    document.cookie = "lastSearchTypes=" + searchTypes;
    var tagList = document.getElementById("tag_list").value;
    if (tagList.length < 1) {
        tagList = "false";
    }
    document.cookie = "lastTagList=" + tagList;
    
    if (searchTerm.length > 0 || tagList.length > 0) {
        $.ajax({
            url: "/pages/handle/search_handle.php",
            type: "GET",
            data: {search_term:searchTerm,search_types:searchTypes,tag_list:tagList},
            success: function(data) {
                document.getElementById("question_results").innerHTML = "";
                document.getElementById("client_results").innerHTML = "";
                if (data != "error") {
                    var resultsArray = data.split("#-#");
                    for (var i = 0; i < resultsArray.length; i++) {
                        if (resultsArray[i] != "") {
                            var secondResultArray = resultsArray[i].split("@-@");
                            if (secondResultArray[0] == "question") {
                                var thirdResultArray = secondResultArray[1].split("-#-");
                                var ratingText = "";
                                var rating = parseInt(thirdResultArray[4]);
                                for (var j = 0; j < rating; j++) {
                                    ratingText += "★";
                                }
                                for (var j = 0; j < 5 - rating; j++) {
                                    ratingText += "☆";
                                }
                                if (searchTerm.length > 0) {
                                    var re = new RegExp(searchTerm, "gi");
                                    var innerText = thirdResultArray[1].replace(re, "<mark>$&</mark>");
                                }
                                else {
                                    innerText = thirdResultArray[1];
                                }
                                var element = `
                                <div id="`+thirdResultArray[0]+`_result_container" class="result_container" onclick="redirectInfo('`+thirdResultArray[0]+`')">
                                    <p id="`+thirdResultArray[0]+`_p" class="result_p">`+innerText+`</p>
                                    <p id="`+thirdResultArray[0]+`_rating" class="rating_p">`+ratingText+` `+thirdResultArray[2]+`</p>
                                </div>
                                `;
                                var rootElement = document.getElementById("question_results");
                                rootElement.innerHTML += element;
                                questionAmmount++;
                            }
                            else if (secondResultArray[0] == "client") {
                                var thirdResultArray = secondResultArray[1].split("-#-");
                                var ratingText = "";
                                var rating = parseInt(thirdResultArray[4]);
                                var rating = parseInt(thirdResultArray[4]);
                                for (var j = 0; j < rating; j++) {
                                    ratingText += "★";
                                }
                                for (var j = 0; j < 5 - rating; j++) {
                                    ratingText += "☆";
                                }
                                if (searchTerm.length > 0) {
                                    var re = new RegExp(searchTerm, "gi");
                                    var innerText = thirdResultArray[1].replace(re, "<mark>$&</mark>");
                                }
                                else {
                                    innerText = thirdResultArray[1];
                                }
                                var element = `
                                <div id="`+thirdResultArray[0]+`_result_container" class="result_container" onclick="redirectInfo('`+thirdResultArray[0]+`')">
                                    <p id="`+thirdResultArray[0]+`_p" class="result_p">`+innerText+`</p>
                                    <p id="`+thirdResultArray[0]+`_rating" class="rating_p">`+ratingText+` ` +thirdResultArray[2]+`</p>
                                </div>
                                `;
                                var rootElement = document.getElementById("client_results");
                                rootElement.innerHTML += element;
                                clientAmmount++;
                            }
                        }
                    }
                    document.getElementById("question_ammount").value = questionAmmount + "";
                    document.getElementById("client_ammount").value = clientAmmount + "";
                    if (questionAmmount > 9) {
                        var rootElement = document.getElementById("question_results");
                        rootElement.innerHTML += `
                            <button type="button" id="load_more_q_button" onclick="loadMoreQuestion()">Load More</button>
                        `;
                    }
                    if (clientAmmount > 9) {
                        var rootElement = document.getElementById("client_results");
                        rootElement.innerHTML += `
                            <button type="button" id="load_more_c_button" onclick="loadMoreClient()">Load More</button>
                        `;
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
function addTag(tag, submit=true) {
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
        if (submit) {
            submitSearch();
        }

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
    submitSearch();
}
function redirectInfo(id) {
    window.location.href = "/pages/info.php?id=" + id;
}
function getCookie(cookieName) {
    var cookieValue = "";
    var cookies = document.cookie;
    var cookieArray = cookies.split(";")
    for (var i = 0; i < cookieArray.length; i++) {
        var currentCookie = cookieArray[i].split("=")
        if (currentCookie[0].replace(" ", "") == cookieName) {
            cookieValue = currentCookie[1];
            return(cookieValue);
        }
    }
    return(cookieValue);
}
function loadMoreQuestion() {
    var searchTerm = document.getElementById("search_input").value;
    if (searchTerm.length < 1) {
        searchTerm = "none-null";
    }
    var tags = document.getElementById("tag_list").value;
    if (tags.length < 1) {
        tags = "none-null";
    }
    var questionAmmount = document.getElementById("question_ammount").value;
    if (searchTerm != "none-null" || tags != "none-null") {
        $.ajax({
            url: "/pages/handle/get_questions_handle.php",
            type: "GET",
            data: {search_term:searchTerm,tags:tags,question_ammount:questionAmmount},
            success: function(data) {
                if (data == "0") {
                    document.getElementById("load_more_q_button").remove();
                }
                else {
                    var addedQuestionAmmount = 0;
                    var returnArray = data.split("#-#");
                    for (var i = 0; i < returnArray.length; i++) {
                        if (returnArray[i] == "") {
                            continue;
                        }
                        var resultArray = returnArray[i].split("-#-");
                        var ratingText = "";
                        var rating = parseInt(resultArray[4]);
                        for (var j = 0; j < rating; j++) {
                            ratingText += "★";
                        }
                        for (var j = 0; j < 5 - rating; j++) {
                            ratingText += "☆";
                        }
                        if (searchTerm.length > 0) {
                            var re = new RegExp(searchTerm, "gi");
                            var innerText = resultArray[1].replace(re, "<mark>$&</mark>");
                        }
                        else {
                            var innerText = resultArray[1];
                        }
                        var element = `
                        <div id="`+resultArray[0]+`_result_container" class="result_container" onclick="redirectInfo('`+resultArray[0]+`')">
                            <p id="`+resultArray[0]+`_p" class="result_p">`+innerText+`</p>
                            <p id="`+resultArray[0]+`_rating" class="rating_p">`+ratingText+` `+resultArray[2]+`</p>
                        </div>
                        `;
                        var rootElement = document.getElementById("question_results");
                        rootElement.innerHTML += element;
                        questionAmmount++;
                        addedQuestionAmmount++;
                    }
                    document.getElementById("load_more_q_button").remove();
                    document.getElementById("question_ammount").value = questionAmmount + "";
                    if (addedQuestionAmmount > 9) {
                        var rootElement = document.getElementById("question_results");
                        rootElement.innerHTML += `
                            <button type="button" id="load_more_q_button" onclick="loadMoreQuestion()">Load More</button>
                        `;
                    }
                }
            }
        });
    }
}
function loadMoreClient() {
    var searchTerm = document.getElementById("search_input").value;
    if (searchTerm.length < 1) {
        searchTerm = "none-null";
    }
    var tags = document.getElementById("tag_list").value;
    if (tags.length < 1) {
        tags = "none-null";
    }
    var clientAmmount = document.getElementById("client_ammount").value;
    if (searchTerm != "none-null" || tags != "none-null") {
        $.ajax({
            url: "/pages/handle/get_clients_handle.php",
            type: "GET",
            data: {search_term:searchTerm,tags:tags,client_ammount:clientAmmount},
            success: function(data) {
                if (data == "0") {
                    document.getElementById("load_more_c_button").remove();
                }
                else {
                    var addedClientAmmount = 0;
                    var returnArray = data.split("#-#");
                    for (var i = 0; i < returnArray.length; i++) {
                        if (returnArray[i] == "") {
                            continue;
                        }
                        var resultArray = returnArray[i].split("-#-");
                        var ratingText = "";
                        var rating = parseInt(resultArray[4]);
                        for (var j = 0; j < rating; j++) {
                            ratingText += "★";
                        }
                        for (var j = 0; j < 5 - rating; j++) {
                            ratingText += "☆";
                        }
                        if (searchTerm.length > 0) {
                            var re = new RegExp(searchTerm, "gi");
                            var innerText = resultArray[1].replace(re, "<mark>$&</mark>");
                        }
                        else {
                            var innerText = resultArray[1];
                        }
                        var element = `
                        <div id="`+resultArray[0]+`_result_container" class="result_container" onclick="redirectInfo('`+resultArray[0]+`')">
                            <p id="`+resultArray[0]+`_p" class="result_p">`+innerText+`</p>
                            <p id="`+resultArray[0]+`_rating" class="rating_p">`+ratingText+` `+resultArray[2]+`</p>
                        </div>
                        `;
                        var rootElement = document.getElementById("client_results");
                        rootElement.innerHTML += element;
                        clientAmmount++;
                        addedClientAmmount++;
                    }
                    document.getElementById("load_more_c_button").remove();
                    document.getElementById("client_ammount").value = clientAmmount + "";
                    if (addedClientAmmount > 9) {
                        var rootElement = document.getElementById("client_results");
                        rootElement.innerHTML += `
                            <button type="button" id="load_more_c_button" onclick="loadMoreClient()">Load More</button>
                        `;
                    }
                }
            }
        });
    }
}
if (document.getElementById("last_page").value == "info") {
    var lastSearchTypes = getCookie("lastSearchTypes");
    if (lastSearchTypes.length > 0) {
        if (lastSearchTypes.includes("questions")) {
            document.getElementById("search_questions").checked = true;
        }
        else {
            document.getElementById("search_questions").checked = false;
        }
        if (lastSearchTypes.includes("clients")) {
            document.getElementById("search_clients").checked = true;
        }
        else {
            document.getElementById("search_clients").checked = false;
        }
        var lastSearchTerm = getCookie("lastSearchTerm");
        if (lastSearchTerm != "none") {
            document.getElementById("search_input").value = lastSearchTerm;
        }
        var lastTagList = getCookie("lastTagList");
        if (!lastTagList == "false") {
        var lastTagListArray = lastTagList.split("#-#");
            for (var i = 0; i < lastTagListArray.length; i++) {
                if (lastTagListArray[i] != "null") {
                    addTag(lastTagListArray[i], false);
                }
            }
        }
        submitSearch();
    }
}
