$(document).ready(function (e) {
$("#uploadimage2").on('submit',(function(e) {
e.preventDefault();
$("#message2").empty();
$('#loading2').show();
$.ajax({
url: "ajax_php_file_msgimg.php", // Url to which the request is send
type: "POST",             // Type of request to be send, called as method
data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
contentType: false,       // The content type used when sending data to the server.
cache: false,             // To unable request pages to be cached
processData:false,        // To send DOMDocument or non processed data file it is set to false
success: function(data)   // A function to be called if request succeeds
{
$('#loading2').hide();
$("#message2").html(data);
}
});
}));

// Function to preview image after validation
$(function() {
$("#file2").change(function() {
$("#message2").empty(); // To remove the previous error message
var file = this.files[0];
var imagefile = file.type;
var match= ["image/jpeg","image/png","image/jpg"];
if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
{
$('#previewing2').attr('src','noimage.png');
$("#message2").html("<p id='error'>Please Select A valid Image File</p>"+"<h4>Note</h4>"+"<span id='error_message'>Only jpeg, jpg and png Images type allowed</span>");
return false;
}
else
{
var reader = new FileReader();
reader.onload = imageIsLoaded;
reader.readAsDataURL(this.files[0]);
}
});
});
function imageIsLoaded(e) {
$("#file2").css("color","green");
$('#image_preview2').css("display", "block");
$('#previewing2').attr('src', e.target.result);
$('#previewing2').attr('width', '250px');
$('#previewing2').attr('height', '230px');
};
});