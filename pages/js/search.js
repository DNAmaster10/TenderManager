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
    if (!(searchTerm.length < 0 || searchTerm == "" ) && (searchTypes != "")) {
        $.ajax({
            url: "/pages/handle/search_handle.php",
            type: "GET",
            data: {search_term:searchTerm,search_types:searchTypes},
            success: function(data) {

            }
        });
    }
}