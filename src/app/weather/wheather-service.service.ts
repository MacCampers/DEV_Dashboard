import { Injectable } from '@angular/core';
import { HttpClient, HttpResponse } from '@angular/common/http';
import { Observable, of, throwError } from 'rxjs';
import { map, delay } from 'rxjs/operators';
import { WheatherConfigService } from './wheather-config.service';

@Injectable({
  providedIn: 'root'
})
export class WheatherService {

  constructor(private http: HttpClient) {
  }

  apiKey = '6f4c3b19ee439a9a769149498748c4de';
  unit = 'metric';

  getCurrentWeather(city: string): Observable<any> {
    const apiCall = `https://api.openweathermap.org/data/2.5/weather?q=${city}&units=${this.unit}&APPID=${this.apiKey}`;
    return this.http.get<any>(apiCall).pipe(
      map(resp => {
        const weather = resp.weather[0];
        const temp = resp.main.temp;
        const x = { weather, temp };
        return x;
      }));
  }

}

export class DevelopmentWeatherService {
  getCurrentWeather(city: string): Observable<any> {
    const weather = { description: 'Rain Rain Rain' };
    const temp = 12.2;
    const x = { weather, temp };
    return of(x).pipe(delay(5000));
  }
}
export function weatherServiceFactory(httpClient: HttpClient, configService: WheatherConfigService) {
  let service: any;
  if (configService.inMemoryApi) {
    service = new DevelopmentWeatherService();
  } else {
    service = new WheatherService(httpClient);
  }
  return service;
}
export let weatherServiceProvider = {
  provide: WheatherService,
  useFactory: weatherServiceFactory,
  deps: [HttpClient, WheatherConfigService]
};
