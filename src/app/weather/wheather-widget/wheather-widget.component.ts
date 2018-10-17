import { Component, OnInit } from '@angular/core';
import { WheatherService } from '../wheather-service.service'

@Component({
  selector: 'app-wheather-widget',
  templateUrl: './wheather-widget.component.html',
  styleUrls: ['./wheather-widget.component.css']
})
export class WheatherWidgetComponent implements OnInit {

  location = {
    city: 'London',
    code: 'uk'
  };

  weather: any;
  value: any;

  constructor(private _weatherService: WheatherService) {

  }

  ngOnInit() {
    this.value = localStorage.getItem('location');
    if (this.value != null) {
      this.location = JSON.parse(this.value);
    } else {
      this.location = {
        city: 'london',
        code: 'uk'
      }
    }

    this._weatherService.getWeather(this.location.city, this.location.code).subscribe((response) => {
      this.weather = response;
    });
  }

}
