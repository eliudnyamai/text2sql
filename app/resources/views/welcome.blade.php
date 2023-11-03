<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
    @vite('resources/css/app.css')
    <script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function (){
    document.getElementById("convertButton").addEventListener("click", updateData);

    async function updateData(event){
      event.preventDefault();
      var formValid = document.forms["form"].checkValidity();
      var text=document.getElementById('text').value;
      const requestData = {
        sql_query: text,
    };
    if(formValid){
      $('#empty-query').hide(); 
    try {
        const response = await fetch("{{ url('/convert-sql')}}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            body: JSON.stringify(requestData),
        });

        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }

        const data = await response.json();
        if (!data.success&&data.code==1) {
            var error_div=document.getElementById('error-div');
            error_div.style.display="block";
            var error_text=document.getElementById('error-text');
            error_text.innerHTML="You have not subscribed.";
            var alert_btn=document.getElementById('alert-btn');
            alert_btn.innerHTML='<a href="{{ route("buy") }}"><button class="bg-white hover:bg-gray-500 text-red-500 px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-red-300">SUBSCRIBE</button> </a>'
         

          }
        if (!data.success&&data.code==2) {
          var error_div=document.getElementById('error-div');
            error_div.style.display="block";
            var error_text=document.getElementById('error-text');
            error_text.innerHTML="You have not subscribed."
            var alert_btn=document.getElementById('alert-btn');
            alert_btn.innerHTML='<a href="{{ route("buy") }}"><button class="bg-white hover:bg-gray-500 text-red-500 px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-red-300">SUBSCRIBE</button> </a>'
         
          }
        if (!data.success&&data.code==3) {
          var error_div=document.getElementById('error-div');
            error_div.style.display="block";
            var error_text=document.getElementById('error-text');
            error_text.innerHTML="You Cancelled Subscription.";
            var alert_btn=document.getElementById('alert-btn');
            alert_btn.innerHTML='<a href="{{ route("resume") }}"><button class="bg-white hover:bg-gray-500 text-red-500 px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-red-300">RESUME</button> </a>'
         
          }
        if (!data.success&&data.code==4) {
          var error_div=document.getElementById('error-div');
            error_div.style.display="block";
            var error_text=document.getElementById('error-text');
            error_text.innerHTML="Your Subscription Is Unpaid."
            var alert_btn=document.getElementById('alert-btn');
            alert_btn.innerHTML='<a href="{{ route("dashboard") }}"><button class="bg-white hover:bg-gray-500 text-red-500 px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-red-300">UPDATE PAYMENT INFO</button> </a>'
          }
        if (!data.success&&data.code==5) {
            var error_div=document.getElementById('error-div');
            error_div.style.display="block";
            var error_text=document.getElementById('error-text');
            error_text.innerHTML="You are not logged in. Please <button><a href='{{ url('/login')}}'>LOG IN</a></button>"
        }
        document.getElementById('sql-result').innerHTML=data.sql;
       // return data.sql; // Return the converted SQL
    } catch (error) {
        console.error("Error:", error);
        return null; // Hande the error and return null or an appropriate value    
}
    }
    else{
      $('#text').focus(); 
      $('#empty-query').show(); 
    }
}
});
function copyToClipboard() {
        document.getElementById("sql-result").select();
        document.execCommand('copy');
    }
</script>
</head>
<body>
  <header>
    <nav class="bg-white border-gray-200 px-4 lg:px-6 py-2.5 dark:bg-gray-800">
        <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl">
            <a href="/"  class="flex items-center">
                <img src="{{ asset('img/text2sql.png') }}" class="mr-3 h-6 sm:h-9" alt="Text2SQL" />
                <span class="self-center text-xl font-semibold whitespace-nowrap dark:text-white">Text2SQL</span>
            </a>
            @if (Route::has('login'))
           
            @auth
            <div class="flex items-center lg:order-2">
   
            <a href="#" class="text-gray-800 dark:text-white hover:bg-gray-50 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-4 lg:px-5 py-2 lg:py-2.5 mr-2 dark:hover:bg-gray-700 focus:outline-none dark:focus:ring-gray-800" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> {{ __('Logout') }}</a>
            
                @if (App\Models\LemonSqueezyCustomers::where('billable_id', Auth::id())->exists())
                 <a href="{{ url('/dashboard') }}" class="focus:outline-none text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-900">CUSTOMER PORTAL</a>
                @else 
                  <a href="{{ url('/buy') }}" class="focus:outline-none text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-900">SUBSCRIBE</a>
                @endif
                
              
               
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>
            </div>
            @else
            <div class="flex items-center lg:order-2">
                <a href="{{ route('login') }}" class="text-gray-800 dark:text-white hover:bg-gray-50 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-4 lg:px-5 py-2 lg:py-2.5 mr-2 dark:hover:bg-gray-700 focus:outline-none dark:focus:ring-gray-800">Log In</a>
          
            @if (Route::has('register'))
            <div class="flex items-center lg:order-2">
                <a href="{{ route('register') }}" class="focus:outline-none text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-900">REGISTER</a>
            </div>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
    </nav>
</header>
@if ($message = Session::get('error'))
<div id="alert" class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
    <p>You Are Already Subscribed</p>
</div>
@endif
      <main class="mx-auto p-7 rounded-lg border-solid border-2 dark:borderblack border-purple-700 w-3/4">
      <div style="display:none" id="error-div" class="relative rounded-lg bg-red-500 text-white p-4">
  <div class="flex items-center justify-between">
    <div class="flex items-center space-x-4">
      <svg class="w-5 h-5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
        <path d="M11 7h2v7h-2z"/>
        <path d="M11 16h2v2h-2z"/>
      </svg>
      <span id="error-text" class="font-semibold"></span>
    </div>
    <div id="alert-btn">
    
    </div>
    
  </div>
</div>

      <form id="form" class="" action="{{ route('convert') }}" method="POST" class="mt-4">
      
      <div class="my-3">
      @csrf  
          <label for="text" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Describe Your Query</label>
          <textarea autofocus id="text" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-purple-700 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="For example: all boys from the table students" required ></textarea>
       <label id="empty-query" style="display:none" class="text-red-500" for="text">This is a required field*</label>
        </div>
          <div class="text-center ">
          @if (auth()->check())
          <button id="convertButton" type="submit" class="focus:outline-none text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-900">CONVERT</button>
@else
<a href="{{ route('login') }}" class="text-gray-800 dark:text-white hover:bg-gray-50 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-4 lg:px-5 py-2 lg:py-2.5 mr-2 dark:hover:bg-gray-700 focus:outline-none dark:focus:ring-gray-800">Log In</a>
@endif
          </div>
</form>
          <div class="my-3">
            <label for="sql-result" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your Converted SQL Query</label>
            <textarea  id="sql-result" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-purple-700 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Your Converted SQL Query Appears Here"></textarea>         
          </div>
          <div class="text-center ">
          @if (auth()->check())
            <button onclick="copyToClipboard()" type="button" class="focus:outline-none text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-900">COPY</button>
            @else
            <a href="{{ route('login') }}" class="text-gray-800 dark:text-white hover:bg-gray-50 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-4 lg:px-5 py-2 lg:py-2.5 mr-2 dark:hover:bg-gray-700 focus:outline-none dark:focus:ring-gray-800">Log In</a>
@endif
          </div>
</form>
      </main>
               
<footer class="bg-white text-center  rounded-lg shadow m-4 dark:bg-gray-800">
  <div class="w-full mx-auto max-w-screen-xl p-4 md:flex md:items-center md:justify-between">
    <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">© 2023 <a href="https://flowbite.com/" class="hover:underline">Toolske™</a>. All Rights Reserved.
  </span>
  <ul class="flex justify-center flex-wrap items-center mt-3 text-sm font-medium text-gray-500 dark:text-gray-400 sm:mt-0">
      <li>
          <a href="/about" class="mr-4 hover:underline md:mr-6 ">About</a>
      </li>
      <li>
          <a href="/privacy" class="mr-4 hover:underline md:mr-6">Privacy Policy</a>
      </li>
      <li>
          <a href="/refund" class="mr-4 hover:underline md:mr-6">Refund Policy</a>
      </li>
      
  </ul>
  </div>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
    const alert = document.getElementById('alert');
    
    if (alert) {
        alert.classList.remove('hidden'); // Show the alert

        setTimeout(function() {
            alert.style.display = "none"; // Hide the alert after 5 seconds
        }, 3000);
    }
});

  </script>
</footer>
</body>
</html>