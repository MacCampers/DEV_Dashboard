import { Component, OnInit, Output, EventEmitter } from '@angular/core';
import { FormGroup, FormBuilder, Validators } from '@angular/forms';

@Component({
  selector: 'app-weather-setting',
  templateUrl: './weather-setting.component.html',
  styleUrls: ['./weather-setting.component.css']
})
export class WeatherSettingComponent implements OnInit {

  form: FormGroup;
  @Output()
  create = new EventEmitter();

  constructor(private formBuilder: FormBuilder) { }

  ngOnInit() {
    this.form = this.formBuilder.group({
      city: ['Nice', Validators.required],
    })
  }

  createCity() {
    if(this.form.valid) {
      this.create.emit(this.form);
    }
  }
}
