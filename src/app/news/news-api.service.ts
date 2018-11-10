import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { AngularFireDatabase } from 'angularfire2/database';


@Injectable({
  providedIn: 'root'
})
export class NewsApiService {

  api_key = 'b56838fdba0d4bbe8d9d43e33dce0e6d';

  constructor(private http: HttpClient, private afDB: AngularFireDatabase) { }
  initSources() {
    return this.http.get('https://newsapi.org/v2/sources?language=en&apiKey=' + this.api_key);
  }
  initArticles() {
    return this.http.get('https://newsapi.org/v2/top-headlines?sources=techcrunch&apiKey=' + this.api_key);
  }
  getArticlesByID(source: String) {
    return this.http.get('https://newsapi.org/v2/top-headlines?sources=' + source + '&apiKey=' + this.api_key);
  }

  getNewsDatabase() {
    return this.afDB.database.ref('/widget/news').once('value').then(function(DataSnapshot) {
      return DataSnapshot.val();
    })
  }

  updateIsActive0() {
    return this.afDB.object('/widget/news').update({isActive : 0});
  }

  updateIsActive1() {
    return this.afDB.object('/widget/news').update({isActive : 1});
  }
} 