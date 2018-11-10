import { Component, OnInit } from '@angular/core';
import { WeatherService } from '../weather-service.service';
import { AngularFireDatabase, AngularFireObject } from 'angularfire2/database';
import { Observable } from "rxjs"
import { DataSnapshot } from '@angular/fire/database/interfaces';
import { map } from 'rxjs/operators';

@Component({
  selector: 'app-weather-city',
  templateUrl: './weather-city.component.html',
  styleUrls: ['./weather-city.component.css']
})

export class WeatherCityComponent implements OnInit {

  widget: any;

  constructor(public weatherService: WeatherService, public afDb: AngularFireDatabase) {
  }

  city = '';
  weather = '?';
  temp = 0;
  img = 0;
  failedToLoad: boolean;

  ngOnInit() {
    this.weatherService.getWeatherDatabase().then(z => {
      this.city = z.city;
      this.weatherService.getCurrentWeather(this.city).subscribe(x => {
        this.img = x.weather.id;
        this.weather = x.weather.description;
        this.temp = x.temp;
      },
        error => {
          console.log('error occured', error);
          this.failedToLoad = true;
        });
    })
  }
}
