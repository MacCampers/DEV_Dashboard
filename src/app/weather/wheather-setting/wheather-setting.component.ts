import { Component, OnInit } from '@angular/core';
import {Router} from '@angular/router';

@Component({
  selector: 'app-wheather-setting',
  templateUrl: './wheather-setting.component.html',
  styleUrls: ['./wheather-setting.component.css']
})
export class WheatherSettingComponent implements OnInit {

  city:string;
  code:string;

  constructor(private router: Router) { }

  ngOnInit() {
  }

  saveForm() {
    let location = {
      city:this.city,
      code:this.code
    }
    localStorage.setItem('location', JSON.stringify(location));
    this.router.navigate(['/dashboard']);
  }
}