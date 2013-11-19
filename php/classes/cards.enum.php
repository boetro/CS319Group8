<?php

// cards enum
class Cards 
{
	const OneOfHearts = 0;
	const OneOfClubs = 1;
	const OneOfDiamonds = 2;
	const OneOfSpades = 3;

	const TwoOfHearts = 4;
	const TwoOfClubs = 5;
	const TwoOfDiamonds = 6;
	const TwoOfSpades = 7;

	const ThreeOfHearts = 8;
	const ThreeOfClubs = 9;
	const ThreeOfDiamonds = 10;
	const ThreeOfSpades = 11;

	const FourOfHearts = 12;
	const FourOfClubs = 13;
	const FourOfDiamonds = 14;
	const FourOfSpades = 15;

	const FiveOfHearts = 16;
	const FiveOfClubs = 17;
	const FiveOfDiamonds = 18;
	const FiveOfSpades = 19;

	const SixOfHearts = 20;
	const SixOfClubs = 21;
	const SixOfDiamonds = 22;
	const SixOfSpades = 23;

	const SevenOfHearts = 24;
	const SevenOfClubs = 25;
	const SevenOfDiamonds = 26;
	const SevenOfSpades = 27;

	const EightOfHearts = 28;
	const EightOfClubs = 29;
	const EightOfDiamonds = 30;
	const EightOfSpades = 31;

	const NineOfHearts = 32;
	const NineOfClubs = 33;
	const NineOfDiamonds = 34;
	const NineOfSpades = 35;

	const TenOfHearts = 36;
	const TenOfClubs = 37;
	const TenOfDiamonds = 38;
	const TenOfSpades = 39;

	const JackOfHearts = 40;
	const JackOfClubs = 41;
	const JackOfDiamonds = 42;
	const JackOfSpades = 43;

	const QueenOfHearts = 44;
	const QueenOfClubs = 45;
	const QueenOfDiamonds = 46;
	const QueenOfSpades = 47;

	const KingOfHearts = 48;
	const KingOfClubs = 49;
	const KingOfDiamonds = 50;
	const KingOfSpades = 51;

	const AceOfHearts = 52;
	const AceOfClubs = 53;
	const AceOfDiamonds = 54;
	const AceOfSpades = 55;

	public static function randomCard() {
		return rand(0,55);
	}
}

?>