// fetch('user/checkLogin.php',{
//   method: "POST",
//   headers:{
//       "Content-Type":"application/json",
//   },
//   body:JSON.stringify({
// }),
// })
// .then(response=>response.json())
// .then(data=>{
//   // console.log(data);
//   if(data == false){
//       document.getElementById('profileIcon').style.display='none';
//       document.getElementById('cartIcon').style.display='none';
//       document.getElementById('logoutIcon').style.display='none';

//   }else{
//       document.getElementById('loginLi').style.display='none';
//       document.getElementById('signupLi').style.display='none';
      
//   }
// })
// .catch(error=>{
//   alert("Error:",error);
// })

// const swiper = new Swiper('.swiper', {
  
//     autoplay: {
//         delay: 2000, 
//         disableOnInteraction: false,
//     },
//     loop: true,
  
//     pagination: {
//       el: '.swiper-pagination',
//       clickable: true, 
//     },
  
//     navigation: {
//       nextEl: '.swiper-button-next',
//       prevEl: '.swiper-button-prev',
//     },
  
   
//   });

//start the fetch job from here till we end 
let category = document.querySelector('#category');

function fetchCategory() {
  fetch('admin/admin/cata.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(" "),
  })
  .then(r => r.json())
  .then(function(data) {
    console.log(data);
    data.forEach(function(e, index) {
      category.innerHTML += `
            <div class="col-12 col-md-4 p-5 mt-3">
                <h5 class="text-center mt-3 mb-3">${data[index].name}</h5>
                <form action="admin/admin/fetch_product.php" method="post">
                <input type="hidden" name="category" value="${data[index].category_id}">
                <input type="submit" value="go shop" name="submit" class="btn btn-success">
                </form>
            </div>
      `
    })
  })
}
fetchCategory();

category.addEventListener("change", function() {
  const selected = category.value;
  if (selected) {
    window.location.href = "user/category.html"
  }
})



//cart and profile
let selectCategory=document.getElementById('category');

selectCategory.addEventListener('change',function(){
    
})
document.getElementById('profileIcon').addEventListener('click',function(){
    fetch('user/checkLogin.php',{
        method: "POST",
        headers:{
            "Content-Type":"application/json",
        },
        body:JSON.stringify({
    }),
    })
    .then(response=>response.json())
    .then(data=>{
        if(data == false){
            window.location.href=('user/login.html');
        }else{
                window.location.href=('user/profile.html');
        }
    })
    .catch(error=>{
        alert("Error:",error);
    })

})

function checkUser(){
  fetch('user/checkLogin.php',{
      method: "POST",
      headers:{
          "Content-Type":"application/json",
      },
      body:JSON.stringify({
  }),
  })
  .then(response=>response.json())
  .then(data=>{
      if(data == false){
          window.location.href=('user/login.html');
      }else{
              window.location.href=('user/cart.html');
      }
  })
  .catch(error=>{
      alert("Error:",error);
  })

}

document.getElementById('logoutIcon').addEventListener('click',function(){

  fetch('user/logout.php',{
      method: "POST",
      headers:{
          "Content-Type":"application/json",
      },
      body:JSON.stringify({
  }),
  })
  .then(response=>response.json())
  .then(data=>{
      // console.log(data);
      window.location.href=('index.html');
  })
  .catch(error=>{
      alert("Error:",error);
  })

})
