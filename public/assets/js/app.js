async function ajaxSubmit(form){
  const data = new FormData(form);
  const response = await fetch(form.action,{method:form.method,body:data,headers:{'X-Requested-With':'XMLHttpRequest'}});
  const json = await response.json();
  if(!response.ok){alert(json.error||'Erreur');return;}
  if(json.redirect){window.location.href=json.redirect;return;}
  window.location.reload();
}
document.querySelectorAll('form[data-ajax]').forEach(f=>f.addEventListener('submit',e=>{e.preventDefault();ajaxSubmit(f)}));

setInterval(async()=>{
  const res = await fetch('/api/notifications');
  if(res.ok){const j = await res.json(); if(j.data?.length){console.log('Notifications',j.data.length);}}
},15000);
