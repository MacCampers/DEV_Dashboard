import { Component, OnInit, Output, EventEmitter } from '@angular/core';
import { FormGroup, FormBuilder, Validators } from '@angular/forms';
import { WeatherService } from '../weather-service.service';
import { Location } from '@angular/common';

@Component({
  selector: 'app-weather-setting',
  templateUrl: './weather-setting.component.html',
  styleUrls: ['./weather-setting.component.css']
})

export class WeatherSettingComponent implements OnInit {

  form: FormGroup;

  @Output()
  update = new EventEmitter();

  constructor(private formBuilder: FormBuilder, public weatherService: WeatherService, private location: Location) { }

  ngOnInit() {
    this.form = this.formBuilder.group({
      city: ['', Validators.required]
    })
  }

  updateCity() {
    if(this.form.valid) {
      this.update.emit(this.form);
    location.reload();
    }
  }
  
}
