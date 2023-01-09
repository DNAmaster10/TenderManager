function uploadInfo() {
    document.getElementById("error").value = "";
    document.getElementById("question_input").disabled = true;
    document.getElementById("client_input").disabled = true;
    document.getElementById("year_input").disabled = true;
    document.getElementById("answer_input").disabled = true;
    document.getElementById("tag_input").disabled = true;
    document.getElementById("additional_notes_input").disabled = true;
    var question = document.getElementById("question_input").value;
    var client = document.getElementById("client_input").value;
    var year = document.getElementById("year_input").value;
    var answer = document.getElementById("answer_input").value;
    var tags = document.getElementById("tag_list").value;
    var notes = document.getElementById("additional_notes_input").value;
    if (question.length < 1) {
        document.getElementById("error").value = "Enter a question";
    }
    if (answer.length < 1) {
        document.getElementById("error").value = "Enter an answer";
    }
    if (tags.length < 1) {
        document.getElementById("error").value = "Attach at least 1 tag"
    }
    if (client.length < 1) {
        client = "none";
    }
    if (client.length < 1) {
        year = "none";
    }
    if (notes.length < 1) {
        notes = "none";
    }
    $.ajax({
        url: "/pages/handle/handle_add.php",
        type: "POST",
        data: {question:question,client:client,year:year,answer:answer,tags:tags,notes:notes},
        success: function(data) {
            console.log(data);
            data_array = data.split(",");
            if (data_array[0] == "error") {
                document.getElementById("error").value = data_array[1];
                document.getElementById("question_input").disabled = false;
                document.getElementById("client_input").disabled = false;
                document.getElementById("year_input").disabled = false;
                document.getElementById("answer_input").disabled = false;
                document.getElementById("tag_input").disabled = false;
                document.getElementById("additional_notes_input").disabled = false;
                document.getElementById("error").innerHTML = data[1];
            }
            else {
                document.getElementById("question_input").value = "";
                document.getElementById("client_input").value = "";
                document.getElementById("year_input").value = "";
                document.getElementById("answer_input").value = "";
                document.getElementById("tag_list").value = "";
                document.getElementById("additional_notes_input").value = "";
                document.getElementById("question_input").disabled = false;
                document.getElementById("client_input").disabled = false;
                document.getElementById("year_input").disabled = false;
                document.getElementById("answer_input").disabled = false;
                document.getElementById("tag_input").disabled = false;
                document.getElementById("additional_notes_input").disabled = false;
            }
        }
    });

}
function getTags() {
    var tagInput = document.getElementById("tag_input").value;
    $.ajax({
        url: "/pages/handle/get_tags.php",
        type: "GET",
        data: {tag:tagInput},
        success: function (data) {
            console.log(data);
        }
    });
}
document.getElementById("question_input").disabled = false;
document.getElementById("client_input").disabled = false;
document.getElementById("year_input").disabled = false;
document.getElementById("answer_input").disabled = false;
document.getElementById("tag_input").disabled = false;
document.getElementById("additional_notes_input").disabled = false;