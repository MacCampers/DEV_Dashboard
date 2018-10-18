import { Component, OnInit } from '@angular/core';
import { WeatherService } from '../weather-service.service';
import { AngularFireDatabase } from 'angularfire2/database';
import { map } from 'rxjs/operators';
import { analyzeAndValidateNgModules } from '@angular/compiler';

@Component({
  selector: 'app-weather-city',
  templateUrl: './weather-city.component.html',
  styleUrls: ['./weather-city.component.css']
})

export class WeatherCityComponent implements OnInit {

  widget:any;
  CiTy: string;

  constructor(public weatherService: WeatherService, public afDb: AngularFireDatabase) { }

  city = 'Paris';
  weather = '?';
  temp = 0;
  failedToLoad: boolean;

  ngOnInit() {
    console.log(this.weatherService.getWeatherDatabase());
    this.weatherService.getCurrentWeather(this.city).subscribe(x => {
      this.weather = x.weather.description;
      this.temp = x.temp;
    },
      error => {
        console.log('error occured', error);
        this.failedToLoad = true;
      });
  }

}
