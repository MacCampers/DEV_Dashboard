import { Injectable } from '@angular/core';
import { HttpClient, HttpResponse } from '@angular/common/http';
import { Observable, Subject } from 'rxjs';
import { map } from 'rxjs/operators';
import { AngularFireDatabase } from 'angularfire2/database';

@Injectable({
  providedIn: 'root'
})

export class WeatherService {

  constructor(private httpClient: HttpClient, private afDB: AngularFireDatabase) {
  }

  apiKey = '6f4c3b19ee439a9a769149498748c4de';
  unit = 'metric';

  getWeatherDatabase() {
    /* return this.afDB.list('/widget/weather').snapshotChanges().pipe(map(snapshot => {
      snapshot[0];
    })); */
    return this.afDB.database.ref('/widget/weather');
  }

  getCurrentWeather(city: string): Observable<any> {
    const apiCall = `https://api.openweathermap.org/data/2.5/weather?q=${city}&units=${this.unit}&APPID=${this.apiKey}`;
    return this.httpClient.get<any>(apiCall).pipe(
      map(resp => {
        const weather = resp.weather[0];
        const temp = resp.main.temp;
        const x = { weather, temp };
        return x;
      }));
  }
}