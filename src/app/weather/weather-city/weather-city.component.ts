import { Component, OnInit } from '@angular/core';
import { WeatherService } from '../weather-service.service';
import { AngularFireDatabase, AngularFireObject } from 'angularfire2/database';
import { Observable } from "rxjs"
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

  city = 'Paris'
  weather = '?';
  temp = 0;
  failedToLoad: boolean;

  ngOnInit() {
    var chien = this.weatherService.getWeatherDatabase();
    chien.orderByKey().on('child_added', function(snapshot) {
      console.log(snapshot[0]);
    })
    console.log(chien);
    /* this.weatherService.getWeatherDatabase().subscribe(resp => {
      this.city$ = resp;
      console.log('la variable', this.city$);
    }) */
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
