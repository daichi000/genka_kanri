function unpwerror(){
  var id = document.getElementById("id").value;
  var pass = document.getElementById("pass").value;

  window.localStorage.setItem("id",id);

  if((id == "") || (pass == "")){
    alert("入力していない箇所があります");
    return false;
  }
}

// function getNOW(){
//   var now = new Date();
//   var year = now.getFullYear();
//   var mon = now.getMonth();
//   var day = now.getDate();
//   return year;
//   document.write("hello");
// }

// function id(){
//   console.log(document.getElementById("id").value);
// }

// function id(){
//   var id = document.getElementById("id").value;
//   var pass = document.getElementById("pass").value;
//   return id;
//   return pass;
// }
