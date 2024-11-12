<!DOCTYPE html>
<html>
<head>
	<title>Coming Soon</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<style>
		body {
			background-color: red;
			color: white;
			font-family: Arial, sans-serif;
			font-size: 18px;
			line-height: 1.5;
			text-align: center;
		}

		h1 {
			font-size: 48px;
			margin-top: 50px;
		}

		#readyforce {
			animation-name: slidein;
			animation-duration: 2s;
			animation-timing-function: ease-in-out;
			animation-iteration-count: infinite;
		}

		#newbrunswick {
			animation-name: bounce;
			animation-duration: 2s;
			animation-timing-function: ease-in-out;
			animation-iteration-count: infinite;
		}

		h2 {
			font-size: 36px;
			margin-bottom: 50px;
			animation-name: pulse;
			animation-duration: 2s;
			animation-timing-function: ease-in-out;
			animation-iteration-count: infinite;
		}

		p {
			font-size: 24px;
			margin-top: 30px;
			margin-bottom: 50px;
		}

		@media only screen and (max-width: 600px) {
			h1 {
				font-size: 36px;
				margin-top: 30px;
			}

			h2 {
				font-size: 24px;
			}

			p {
				font-size: 18px;
				margin-top: 20px;
				margin-bottom: 30px;
			}

			input[type="email"] {
				width: 100%;
				margin-right: 0;
				margin-bottom: 10px;
			}

			input[type="submit"] {
				width: 100%;
			}
		}

		@keyframes slidein {
			0% {
				transform: translateX(-50%);
				opacity: 0;
			}

			100% {
				transform: translateX(0);
				opacity: 1;
			}
		}

		@keyframes bounce {
			0%, 100% {
				transform: translateY(0);
			}

			50% {
				transform: translateY(-20px);
			}
		}

		@keyframes pulse {
			0% {
				transform: scale(1);
			}

			50% {
				transform: scale(1.2);
			}

			100% {
				transform: scale(1);
			}
		}
	</style>
</head>
<body>
	<h1><span id="readyforce">ReadyForce</span><br><span id="newbrunswick">New Brunswick</span></h1>
	<h2>Coming Soon!</h2>
	<p>We're working hard to bring you something special. </p>

	<p>We're excited to share something meaningful with you. Our team is putting the finishing touches on a project that we hope will bring joy and positivity to your life. </p>
</body>
</html>
