<!DOCTYPE html>
<html>
<head>    
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cards</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <style type="text/css">
		    	
    	#memory-board .board {
			display: grid;
    	}

		.flip-container {
			background: #fff;
			border: 1px solid #000;
			margin: 5px;
		}

		.show-imp {
			transform: rotateY(180deg) !important;
		}
			/* flip the pane when hovered */
			.flip-container.flip .flipper, .flip-container.hover .flipper {
				transform: rotateY(180deg);
			}

		.flip-container, .front, .back {
			width: 50px;
			height: 50px;
		}

		/* flip speed goes here */
		.flipper {
			transition: 0.6s;
			transform-style: preserve-3d;

			position: relative;
		}

		/* hide back of pane during swap */
		.front, .back {
			backface-visibility: hidden;

			position: absolute;
			top: 0;
			left: 0;
		}

		/* front pane, placed above back */
		.front {
			z-index: 2;
			/* for firefox 31 */
			transform: rotateY(0deg);
		}

		/* back, initially hidden pane */
		.back {
			transform: rotateY(180deg);
		}

		#memory-board {
			padding: 20px;
			background: #999;
		}

    </style>
</head>
<body>

	<div id="memory-board">
		
		<div class="board" style="margin: 0 auto;"></div>

	</div>

<script>
	var letters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	var output = '';
	var choices = [];
	var tiles = [];

	var board_dimension = [2, 2];

	init_board(board_dimension);
	
	function init_board(dimension = [3, 3]) {
		var times = dimension[0] * dimension[1];
		if (! (times % 2 == 0)) {
			console.log(times % 2);
			times = times -1;
		}

		var grid = '';
		for (var z = 1; z <= ((dimension[0] + dimension[1]) /2); z++) {
			grid += 'auto ';
		}

		jQuery('#memory-board .board').css('grid-template-columns', grid);

		tiles = build_partners(times);

		for (var i = 0; i < times; i++) {
			output += `
				<div id="tile_`+ i +`" class="flip-container " data-value="`+ tiles[i] +`" data-answered="0">
					<div class="flipper">
						<div class="front">
							
						</div>
						<div class="back">
							`+ tiles[i] +`
						</div>
					</div>
				</div>
			`;
		}
		jQuery('#memory-board .board').html(output);
		output = "";

		jQuery('.flip-container').click(function() {
			var id = jQuery(this).attr('id');

			if (! is_answered(id))
				jQuery(this).toggleClass('flip');
			else
				return;

			if (choices.length <= 2) {	
				choices.push(id);
			}

			console.log(choices);
			if (choices.length == 2) {
				console.log("nyeam")
				var ch1 = jQuery('#' + choices[0]).attr('data-value');
				var ch2 = jQuery('#' + choices[1]).attr('data-value');

				if (choices[0] != choices[1]) {
					if (check_two(ch1, ch2)) {
						add_answered(choices[0]);
						add_answered(choices[1]);
						choices = [];
					} else {
						var chs = choices;
						setTimeout(function() {
							console.log("niyahhaha");
							jQuery('#' + chs[0]).toggleClass('flip');
							jQuery('#' + chs[1]).toggleClass('flip');
						}, 1000);
					}
				}
				choices = [];
			}
			setTimeout(function() {
				check_completeness();
			}, 500);
		});
	}

	function check_completeness() {
		var len = jQuery('.flip-container').length;
		var completed = [];
		jQuery('.flip-container').each(function() {
			c = jQuery(this).attr('data-answered');
			if (c == 1)
				completed.push(c);
		});
		if (len == completed.length) {
			if (confirm('You just completed this game, want to play again?'))
				init_board(board_dimension);
		}
	}

	function build_partners(how_many) {
		ret = [];
		for (var j = 0; j < how_many/2; j++) {
			l = generate_random_letter();
			ret.push(l);
			ret.push(l);
		}
		console.log(ret);
		return shuffle(ret);
	}

	function is_answered(id) {
		var s = jQuery('#' + id).attr('data-answered');
		if (s == '0')
			return false;
		else
			return true;
	}

	function add_answered(id) {
		jQuery('#' + id).attr('data-answered', '1');
	}

	function check_two(ch1, ch2) {
		if (ch1 == ch2) 
			return true;
		else
			return false;
	}


	function generate_random_letter() {
		return letters[Math.floor(Math.random() * letters.length)];
	}

	function shuffle(array) {
		var currentIndex = array.length, temporaryValue, randomIndex;

		// While there remain elements to shuffle...
		while (0 !== currentIndex) {

		// Pick a remaining element...
		randomIndex = Math.floor(Math.random() * currentIndex);
		currentIndex -= 1;

		// And swap it with the current element.
		temporaryValue = array[currentIndex];
			array[currentIndex] = array[randomIndex];
			array[randomIndex] = temporaryValue;
		}

		return array;
	}


</script>

</body>
</html>