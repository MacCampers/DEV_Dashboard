import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { AngularFireDatabase } from 'angularfire2/database';

@Injectable({
  providedIn: 'root'
})
export class YoutubeService {

  public url: string = "https://www.googleapis.com/youtube/v3/search"

  constructor(private afDB: AngularFireDatabase, private _http: HttpClient) {
  }

  getYoutubeDatabase() {
    return this.afDB.database.ref('/widget/youtube').once('value').then(function(DataSnapshot) {
      return DataSnapshot.val();
    })
  }

  updateIsActive0() {
    return this.afDB.object('/widget/youtube').update({isActive : 0});
  }

  updateIsActive1() {
    return this.afDB.object('/widget/youtube').update({isActive : 1});
  }
 
  searchVideosGet(values: string): Observable<any> {
   
    let uri = `${this.url}?part=snippet&maxResults=6&q=${values}&key=AIzaSyAqONWjG-vGf-Qr4UC-TEtobIt5xXlr1aA&type=video`;
    return this._http.get<any>(uri);

  }
}
