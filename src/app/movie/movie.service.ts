import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})

export class MovieService {
  ApiKey : string = '2edd3dac1ab90961852c9f33622b026a';
  url: string = 'https://api.themoviedb.org/3/search/movie?api_key='+this.ApiKey+'&language=en-US&query=';
  url1 : string = 'https://api.themoviedb.org/3/movie/now_playing?api_key='+this.ApiKey+'&language=en-US&page=1';
  constructor(private http: HttpClient) { }
  search(queryString: string): Observable<any> {
      let realUrl = this.url + queryString+'&page=1&include_adult=true';
      return this.http.get<any>(realUrl);
  }

  getMovies(): Observable<any> {
    return this.http.get<any>(this.url1);
  }
}
