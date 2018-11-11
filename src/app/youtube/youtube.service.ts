import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class YoutubeService {

  public url: string = "https://www.googleapis.com/youtube/v3/search"

  constructor(private _http: HttpClient) {
  }

 
  searchVideosGet(values: string): Observable<any> {
   
    let uri = `${this.url}?part=snippet&maxResults=6&q=${values}&key=AIzaSyAqONWjG-vGf-Qr4UC-TEtobIt5xXlr1aA&type=video`;
    return this._http.get<any>(uri);

  }
}
