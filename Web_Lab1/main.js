
// Валидация значения Y
function validateY() {

  this.value = this.value.replace(/\,/g, ".");
  this.value = this.value.replace(/[^\d\.\-]/g, "");
  if (this.value.lastIndexOf('-') > 0) {
    this.value = this.value.substr(0, this.value.lastIndexOf('-'));
  }
  var x = parseFloat(this.value);
  if ((x > 3) || (x < -5)) {
    this.value = this.value.substr(0, this.value.length - 1);
  }
  if ((this.value[0] == '-' && (this.value[1] == '.' || this.value.lastIndexOf('.') > 2)) || (this.value[0] != '-' && (this.value[0] == '.' || this.value.lastIndexOf('.') > 1))) {
    this.value = this.value.substr(0, this.value.lastIndexOf('.'));
  }
  if ((this.value.match(/[\.]/g) == null) && (this.value.match(/[0]/g) != null)) {
    if (this.value.match(/[0]/g).length == 1 && !isNaN(parseInt(this.value[this.value.lastIndexOf('0') + 1]))) {
      this.value = this.value.substr(0, this.value.lastIndexOf('0') + 1);
    }
    if (this.value.match(/[0]/g).length == 2) {
      this.value = this.value.substr(0, this.value.lastIndexOf('0'));
    }
  }

}
document.querySelector("#y-textinput").onkeyup = validateY;

function validateX() {
  var inputs = document.getElementsByName("xval[]");
  for (var i = 0; i < inputs.length; i++) {
    if (inputs[i].checked) {
      console.log("x");
      return true;
      
    }
  }
  return false;
}

function validateR() {
  var inputs = document.getElementsByName("rval[]");
  for (var i = 0; i < inputs.length; i++) {
    if (inputs[i].checked) {
      console.log("r");
      return true;
    }
  }
  return false;
}
function validateYy() {
  var val = document.getElementById('y-textinput').value;
  console.log(val);
  if (val == null || val === undefined || val=="") {
    return false;
  }
  return true;
}

$('#input-form').on('submit', function (event) {
  event.preventDefault();
  if (validateYy() & validateR() & validateX()){
  }else{
    alert("Вы ввели не все данные, пожалуйста заполните все поля!");
return;
  }
  console.log($(this).serialize());
  $.ajax({
    url: 'main.php',
    method: 'post',
    dataType: 'json',
    data: $(this).serialize() + '&timezone=' + new Date().getTimezoneOffset(),
    beforeSend: function () {
      $('.button').attr('disabled', 'disabled');
    },
    success: function (data) {
      $('.button').attr('disabled', false);
      $.each(data, function (index, value) {
        if (value.validate) {
          newRow = '<tr>';
          newRow += '<td>' + value.xval + '</td>';
          newRow += '<td>' + value.yval + '</td>';
          newRow += '<td>' + value.rval + '</td>';
          newRow += '<td>' + value.hitres + '</td>';
          newRow += '<td>' + value.curtime + '</td>';
          newRow += '<td>' + value.exectime + '</td>';
          $('#result-table').append(newRow);
        }
      });
    }
  });
});

