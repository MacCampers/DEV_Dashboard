import { Injectable } from '@angular/core';
import { Http } from '@angular/http';
import { map } from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})
export class WheatherService {

  apiKey = '6f4c3b19ee439a9a769149498748c4de';
  url;

  constructor(private http: Http) {
    this.url = 'http://api.openweathermap.org/data/2.5/forecast?q=';
  }

  getWeather(city, code) {
    return this.http.get(this.url + city + ',' + code + '&APPID=' + this.apiKey).pipe(map(res => res.json()));
  }
}
