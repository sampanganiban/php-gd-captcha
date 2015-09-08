<?php

namespace CaptchaMaker;

class CaptchaMaker {

	// Properties
	private $width;
	private $height;
	private $wordLength;
	private $answer = '';
	private $image;
	private $fileName;

	// Function to MAKE a captcha image
	public function makeCaptcha( $width = 200, $height = 100, $wordLength = 6 ) {

		// Save the captcha options
		$this->width 	  = $width;
		$this->height 	  = $height;
		$this->wordLength = $wordLength;

		// Functions to create the captcha
		$this->generateAnswer();
		$this->generateImage();
		$this->generateLineNoise();
		$this->generateDotNoise();
		$this->applyTextToImage();
		
		// This should be the last function that runs
		$this->saveImage();

	}

	// Getter function
	public function getAnswer() {
		return $this->answer;
	}

	// Function to randomly generate an answer
	private function generateAnswer() {

		// List of letters / numbers to user in the captcha
		$list = 'ABCDEFGHIJKLMNPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz123456789';

		// Loop for the $wordLength
		for($i=0; $i<$this->wordLength; $i++) {

			$this->answer .= $list[rand(0, strlen($list) - 1)];

		}

	}

	// Function to add line noise on the image
	private function generateLineNoise() {

		// Loop to display multiple lines on the image
		for( $i=0; $i<10; $i++ ) {
		
			// Generate the color
			$lineColor = imagecolorallocate($this->image, rand(0,255),rand(0,255),rand(0,255));
			
			// Line start X / Y
			$startX = 0;
			$startY = rand(0, $this->height);

			// Line end X / Y
			$endX = $this->width;
			$endY = rand(0, $this->height);

			// Draw the line
			imageline($this->image, $startX, $startY, $endX, $endY, $lineColor);
		}
	}

	// Function to add dots on the image
	private function generateDotNoise() {

		// Prepare the dot color
		$dotColor = imagecolorallocate($this->image, 162, 222, 208);

		// Loop to place the dots
		for($i=0; $i<500; $i++) {

			// Random coordinates
			$x = rand(0, $this->width);
			$y = rand(0, $this->height);

			// Apply the dot to the image
			imagesetpixel($this->image, $x, $y, $dotColor);

		}

	}

	// Function to save the file
	private function saveImage() {

		// Generate a filename
		$this->fileName = 'captcha-'.uniqid().'.jpg';

		// Save the file
		imagejpeg($this->image, 'img/captcha/'.$this->fileName, 80);

	}

	// Function to generate an image
	private function generateImage() {

		// Create a blank image
		$this->image = imagecreatetruecolor($this->width, $this->height);

		// Make the background color
		$backgroundColor = imagecolorallocate($this->image, 30, 139, 195);

		// Apply color to the shape
		// x1, y1 = where the shape starts 
		// x2, y2 = where the shape ends
		imagefilledrectangle($this->image, 0, 0, $this->width, $this->height, $backgroundColor);

	}

	// Function to apply text to the captcha image
	private function applyTextToImage() {

		// Prepare a color for the text
		$textColor = imagecolorallocate($this->image, 228, 241, 254);

		// Spreading out the letters on the image
		$spacing = $this->width / $this->wordLength;

		// To ensure that the letters are in the center of their boxes
		$center = $spacing/2;
		

		// Loop to print each letter on the image
		for($i=0; $i<$this->wordLength; $i++) {

			// Get a letter
			$letter = $this->answer[$i];

			// Generate a random height
			$height = rand(0, $this->height/2);

			// Write the letter to the image
			imagestring($this->image, 5, $spacing * $i + $center, $height, $letter, $textColor);
			
		}

	}

	// Function to GET the file name of the new captcha image
	public function getFileName() {

		return $this->fileName;

	}




















}