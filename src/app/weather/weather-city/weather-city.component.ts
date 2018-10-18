import { Component, OnInit } from '@angular/core';
import { WeatherService } from '../weather-service.service';
import { AngularFireDatabase } from 'angularfire2/database';

@Component({
  selector: 'app-weather-city',
  templateUrl: './weather-city.component.html',
  styleUrls: ['./weather-city.component.css']
})
export class WeatherCityComponent implements OnInit {

  constructor(public weatherService: WeatherService, public afDb: AngularFireDatabase) { }

  city$ = this.weatherService.getCity();
  city = 'Nice';
  weather = '?';
  temp = 0;
  failedToLoad: boolean;

  ngOnInit() {
    console.log(this.afDb.database.ref('/city').once('value'));
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
