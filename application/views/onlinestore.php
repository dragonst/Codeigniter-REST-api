<?php
    $this->load->view('layout/header.php');
?>
<div class="container">
  <div class="row products-container">
    </div>

</div>


<?php
    $this->load->view('layout/footer.php');
?>

    <script>

		if( window.history && window.history.pushState ){

		  history.pushState( "nohb", null, "" );
		  $(window).on( "popstate", function(event){
		    if( !event.originalEvent.state ){
		      history.pushState( "nohb", null, "" );
		      return;
		    }
		  });
		}

			$('.products-container').on('click', '.btn', login);
			$('.navbar-nav').on('click', '.logout', logout);
			$('.navbar-nav').on('click', '.add-product', show_add_product);
			$('.products-container').on('click', '.add-btn', add_product);
			$('.navbar-nav').on('click', '.home', show_home);
			$('.products-container').on('click', '.ask-question', ask_question);
			$('.products-container').on('click', '.answer-button', answer_question);
			$('.products-container').on('click', '.answer-question', show_answer_question);
			$('.products-container').on('click', '.ask-button', show_ask_question);
			$('.navbar-nav').on('click','.login',show_login);
			$('.container').on('click', '.more_products', show_more_products);
			$('.container').on('click', '.more-questions', show_more_questions);
			$('.products-container').on('click','.product', get_product);

      function get_answers(id)
      {
				$.ajax({
					url: "http://waitasecond.quadersoft.cf/api/answer/"+id,
					type: 'GET',
					ContentType: 'application/json',

					}).done(function(response){
						if(response['status'] !== false)
						{
						response.forEach(function(element){
							var user = element['is_vendor'] == 1 ? "vendor" : "client"
							$('*[data-id="'+id+'"]').append
							('<div class="media">\
									<div class="media-body media-right">\
										<h4 class="media-heading">'+user+'</h4>\
											'+element['answer']+'\
									</div>\
							</div>');

						});
					}
					}).fail(function(jqXHR, textStatus, errorThrown){

					});
      }

      function get_questions(id, questions_page = 1)
      {
        $.ajax({
          url: "http://waitasecond.quadersoft.cf/api/question/"+id+'/'+questions_page,
          type: 'GET',
          ContentType: 'application/json',

        }).done(function(response){
          if(response['status'] !== false)
          {
            response.forEach(function(element){
              var user = element['is_vendor'] == 1 ? "vendor" : "client"
              $('.comments').append
              ('<div class="media question" data-id="'+element['id']+'">\
                  <div class="media-body">\
                    <h4 class="media-heading">'+user+'</h4>\
										<span class="answer-question" style="float: left;margin-right: 5px;color: blue;cursor:pointer;"><a href="">reply</a></span>\
                      '+element['question']+'\
                  </div>\
              </div>');
              get_answers(element['id']);
            });
						if(!$('.more-questions')[0])
						{
							$('.product-container').append
							('<div class"row"><a class="more-questions" style="display:block;text-align:center;cursor:pointer;margin-bottom:50px;" data-page="1">Show more</a></div>');
						}
          }
					else{	$('.more-questions').remove();}
console.log('there');
        }).fail(function(jqXHR, textStatus, errorThrown){
					console.log('here');

        });
      }

      function get_products(page = 1)
      {

        $.ajax({
          url: "http://waitasecond.quadersoft.cf/api/product?page="+page,
          type: 'GET',
          ContentType: 'application/json',

        }).done(function(response){

          response.forEach(function(element) {
            $(".products-container").append
            ('<div class="panel panel-default product" style="cursor:pointer" data-id="'+element['id']+'"><div class="panel-heading">'+element['title']+ '<br>Price: '+element['price']+'</div><div class="panel-body">'+element['description']+'</div></div>');

        });

				if(!$('.more_products')[0])
				{
					$('.container').append
					('<div class="row more_pr_btn" style="text-align:center;margin-bottom:50px;">\
						<button class="btn-primary btn more_products" data-page="1">Show more</button>\
				    </div>');
				}

        }).fail(function(jqXHR, textStatus, errorThrown){
          alert('FAILED! NO MORE PRODUCTS');
        });
      }

      function get_product()
      {

        	var id;

          id = $(this).data("id");
					clear();
          $.ajax({
              url: "http://waitasecond.quadersoft.cf/api/product/" + id,
              type: 'GET',
              ContentType: 'application/json',

            }).done(function(response){
              $('.products-container').append
              ('<div class="col-md-6 col-md-offset-3 product-container" data-id="'+response['id']+'">\
              <h3>'+response['title']+'</h3>\
              <h5>Price:'+response['price']+'</h5>\
              <p>Description:</p>\
              <p>'+response['description']+'</p>\
              <h3>Comments:</h3>\
            <div class="comments"></div>\
						<button class="btn ask-button" style="margin-top:20px;margin-bottom:50px;">Ask Question</button>\
						');

            get_questions(response['id']);
            }).fail(function(jqXHR, textStatus, errorThrown){
              alert('FAILED! ERROR: ' + errorThrown);
            });

      }

			function show_login()
			{
					clear();
					$('.products-container').append
					('<div class="col-md-6 col-md-offset-3"><div class="input-group" style="margin-bottom:20px;">\
					  <span class="input-group-addon">@</span>\
					  <input type="text" class="form-control username" placeholder="Username">\
					</div>\
					<div class="input-group">\
					<span class="input-group-addon">@</span>\
					<input class="form-control password" type="password" placeholder="Password">\
					</div>\
					<p style="margin-top:20px"><a class="btn btn-primary" role="button">Login</a></p></div>');

			}

function login()
{
	var username = $('.username').val();
	var password = $('.password').val();

	$.ajax({
	  url: "http://waitasecond.quadersoft.cf/api/authentication/login",
	  type: 'POST',
	  ContentType: 'application/json',
	  data: {'data': {"username": username, "password": password}}
	}).done(function(response){
	  if(response == 'logged in')
		{
			clear();
			get_products();
			$('.login').remove();
			$('.navbar-nav').append
			('<li class="add-product">\
            <a href="#">Add Product</a>\
          </li>\
					<li class="logout">\
            <a href="#">Logout</a>\
          </li>');
		}
		else if(response == 'error')
		{
			alert("username or password incorrect.");
		}
	}).fail(function(jqXHR, textStatus, errorThrown){

	});
}

function logout()
{
	$.ajax({
	  url: "http://waitasecond.quadersoft.cf/api/authentication/logout",
	  type: 'GET',

	}).done(function(response){
		$('.logout').remove();
		$('.add-product').remove();
		$('.navbar-nav').append
		('<li class="login">\
					<a href="#">Login</a>\
				</li>');
				clear();
				get_products();
	});
}

function clear()
{
	  $('.products-container').empty();
		$('.more_pr_btn').remove();
}


function show_home()
{
	clear();
	get_products();
}

function show_add_product()
{
	clear();
	$('.products-container').append
	('<div class="col-md-6 col-md-offset-3">\
	\<div class="input-group" style="margin-bottom:20px;">\
		<span class="input-group-addon">Title</span>\
		<input type="text" class="form-control title" placeholder="Product Title">\
	</div>\
	<div class="input-group">\
	<span class="input-group-addon">Price</span>\
	<input type="text" class="form-control price" placeholder="Price">\
	</div>\
	<div class="input-group" style="margin-bottom:20px;margin-top:20px">\
		<span class="input-group-addon">Description</span>\
		<textarea type="text" class="form-control description" placeholder="Description"></textarea>\
	</div>\
	<p style="margin-top:20px"><a class="btn btn-primary add-btn" role="button">Add</a></p></div>');

}

function add_product()
{
	var title = $('.title').val();
	var price = $('.price').val();
	var description = $('.description').val();
	$.ajax({
	  url: "http://waitasecond.quadersoft.cf/api/product",
	  type: 'POST',
	  ContentType: 'application/json',
	  data: {'data': {"title": title, "price": price, "description": description}}
	}).done(function(response){
	  if(response['success'] == true)
		{
			clear();
			get_products();
		}
		else
		{
			alert("Error!");
		}
	}).fail(function(jqXHR, textStatus, errorThrown){
	  alert('FAILED! ERROR: ' + errorThrown);
	});
}

function ask_question()
{
		$.ajax({
	  url: "http://waitasecond.quadersoft.cf/api/question",
	  type: 'POST',
	  data: {'data': {'product_id': $('.product-container').data('id'), 'question': $('.question-input').val()}},
	  ContentType: 'application/json',

	}).done(function(response){
		var user = response['is_vendor'] == 1 ? 'vendor': 'client';
	  console.log(response);
		 $(window).scrollTop(0);
		$('.comments').prepend
		('<div class="media question" data-id="'+response['id']+'">\
				<div class="media-body">\
					<h4 class="media-heading">'+user+'</h4>\
					<span class="answer-question" style="float: left;margin-right: 5px;color: blue;cursor:pointer;"><a>reply</a></span>\
						'+response['question']+'\
				</div>\
		</div>');
		$('.question-group').remove();

	}).fail(function(jqXHR, textStatus, errorThrown){
	  alert('FAILED! ERROR: ' + errorThrown);
	});

}

function show_answer_question(e)
{
	e.preventDefault();
	$('.question-group').remove();
	$('.answer-group').remove();

	$(this).parents('.question').append
	('<div class="input-group answer-group" style="margin-top:20px;">\
		<input class="form-control answer-input" placeholder="Answer...">\
			<span class="input-group-btn">\
				<button class="btn btn-default answer-button" type="button">Submit</button>\
			</span>\
		</div>\
	</div>');
}

function show_ask_question()
{
	$('.question-group').remove();
	$('.answer-group').remove();
	$('.ask-button').remove();
	$('.product-container').append
	('<div class="input-group question-group" style="margin-top:20px;margin-bottom:50px;">\
		<input class="form-control question-input" placeholder="Ask...">\
			<span class="input-group-btn">\
				<button class="btn btn-default ask-question" type="button">Submit</button>\
			</span>\
		</div>\
	</div>');
}

function answer_question()
{

var question = $(this).parents('.question');
	$.ajax({
  url: "http://waitasecond.quadersoft.cf/api/answer",
  type: 'POST',
  data: {'data': {'question_id': $(this).parents('.question').data('id'), 'answer': $('.answer-input').val()}},
  ContentType: 'application/json',

}).done(function(response){
	console.log(response);
	var user = response['is_vendor'] == 1 ? 'vendor': 'client';
$('.answer-group').remove();
question.append
('<div class="media question" data-id="'+response['id']+'">\
		<div class="media-body media-right">\
			<h4 class="media-heading">'+user+'</h4>\
				'+response['answer']+'\
		</div>\
</div>');
}).fail(function(jqXHR, textStatus, errorThrown){

});
}

function show_more_products()
{
 $('.more_products').data('page', $('.more_products').data('page') + 1);

	get_products($('.more_products').data('page'));
}

function show_more_questions()
{
	var product_id = $('.product-container').data('id');
	$('.more-questions').data('page', $('.more-questions').data('page') + 1);
	get_questions(product_id, $('.more-questions').data('page'));

}

      get_products();
    
    </script>
  <body>
</html>
