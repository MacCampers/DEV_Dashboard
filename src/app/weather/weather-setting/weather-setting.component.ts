import { Component, OnInit, Output, EventEmitter } from '@angular/core';
import { FormGroup, FormBuilder, Validators } from '@angular/forms';
import { WeatherService } from '../weather-service.service';

@Component({
  selector: 'app-weather-setting',
  templateUrl: './weather-setting.component.html',
  styleUrls: ['./weather-setting.component.css']
})


export class WeatherSettingComponent implements OnInit {

  constructor(private formBuilder: FormBuilder, private weatherService: WeatherService) { }

  ngOnInit() {
  
  }


}
