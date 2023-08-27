async function post(val) {
  val = val.id;
  let formInputs = document.querySelectorAll("form > input");
  //Assign all for inputs to a new FormData obj
  let formData = new FormData();
  for (let i = 0; i < formInputs.length; i++) {
    formData.append(formInputs[i].name, formInputs[i].value);
  }
  //Send the formData to the server
  let result = await fetch("../app/controllers/" + val + ".php", {
    method: "POST",
    body: formData,
  });
  //Check if there is a location header
  if (result.redirected) {
    window.location.href = result.url
  }

}

async function get(val) {
  val = val.id;
  console.log(val);
  let result = await fetch("../app/controllers/" + val + ".php",
  {
  method:"GET",
  });
  console.log(result);
  if (await result.redirected) {
    window.location.href = result.url
  }

}
