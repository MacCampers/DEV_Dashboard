import { Injectable } from '@angular/core';
import { HttpClient, HttpResponse } from '@angular/common/http';
import { Observable, Subject } from 'rxjs';
import { map } from 'rxjs/operators';
import { AngularFireDatabase } from 'angularfire2/database';

@Injectable({
  providedIn: 'root'
})

export class WeatherService {
  widget: any;
  city:any;

  constructor(private httpClient: HttpClient, private afDB: AngularFireDatabase) { 
  }

  apiKey = '6f4c3b19ee439a9a769149498748c4de';
  unit = 'metric';

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

  getWeatherDatabase(): Observable<any> {
    /* const url = 'https://epitechdashboard.firebaseio.com/widget/weather';
    return this.httpClient.get(url).pipe(
      map(resp => {
        const z = resp;
        console.log(z);
        return z;
      })); */
     return this.widget = this.afDB.list('/widget/weather').valueChanges().pipe(map(snapshot => {
      const city  = snapshot[0];
      return city;
    })); 
  }
}