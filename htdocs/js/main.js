
async function getData() {
  //local json cuz in devil box it had cors error
  const response = await fetch("/js/users.json")
  return response.json();
}



function justDLTheWholeThing(data = {}, parent) {
  let dl = document.createElement('dl');
  for (const [key, value] of Object.entries(data)) {
    if( typeof value === 'object' &&
      !Array.isArray(value) &&
      value !== null) {
        let newDiv = document.createElement('div');
        newDiv.classList.add("subTree");
        justDLTheWholeThing(value, newDiv);
        dl.append(newDiv);
      }
      else {
        if (['name', 'username', 'email', 'website', 'role'].includes(key)){
          let dt = document.createElement('dt');
          dt.textContent = key;
          let dd = document.createElement('dd');
          dd.textContent = value;
          dl.append(dt, dd);
        }
      }
  }
  parent.append(dl);
}

getData().then((data) => {
  console.log(data);
  const parentDiv = document.getElementById('dataTree');
  justDLTheWholeThing(data, parentDiv);
})
