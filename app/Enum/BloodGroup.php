<?php 

namespace App\Enum;

enum BloodGroup: string {
  case A_POS = 'A+';
  case A_NEG = 'A-';
  case B_POS = 'B+';
  case B_NEG = 'B-';
  case AB_POS = 'AB+';
  case AB_NEG = 'AB-';
  case O_POS = 'O+';
  case O_NEG = 'O-';
}