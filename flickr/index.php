<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title>Flickr Search</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

	<style>
		#search-form {
			width: 300px;
		}
	</style>
	<script>
		var key = '403d5274ed5eb1c0131d74485aaa30dd';
		var base_url = "https://api.flickr.com/services/rest/?method=flickr.photos.search&api_key=" + key + "&format=json&nojsoncallback=1";

		$(document).ready(function () {

			var displayPhotos = function (photos) {  // function to display photos.
				if(photos.length > 0){  // simple if-else statement
					$('#photo-list').html('');
				}else{
					$('#photo-list').html('No Photos Found');
				}
				for (var index in photos) {  // loop photos array
					var photoObj = photos[index];
					var url = 'https://farm' + photoObj.farm + '.staticflickr.com/' + photoObj.server + '/' + photoObj.id + '_' + photoObj.secret + '.jpg'
					var img = $('<img/>').attr('src', url).width(250);
					$('#photo-list').append(img);
				}
			}

			$('body').on('click', '#search-btn', function () { // onclick handler
				var val = $('#search').val(); //get value from search form
				var search_url = base_url + "&text=" + val; //append to search_url
				var photos = [];

				$('#photo-list').html('Searching'); // while searching 

				$.ajax({ //ajax call to flicker server 
					url: search_url,
					dateType: 'json',  // expect JSON file back
					crossDomain: true, // title says it all
					success: function (response) {
						photos = response.photos.photo; // all photos in Array(photos). 
						displayPhotos(photos); // call displayPhotos Function.
					},
					error: function (response) {
						console.error(response);
					}
				});


			});
		});
	</script>

</head>

<body>
	<div id="search-form">
		<div class="panel panel-default panel-primary">
			<div class="panel-heading">Search Flickr</div>
			<div class="panel-body">
				<div class="form-group">
					<div class="input-group input-group-lg">
						<span class="input-group-addon glyphicon glyphicon-search"></span>
						<input id="search" type="text" class="form-control" placeholder="Search" name="search" />
					</div>
				</div>
				<button id="search-btn" class="btn btn-lrg btn-default pull-right">Search</button>
			</div>
		</div>
	</div>
	<div id="photo-list">
	</div>
</body>

</html>