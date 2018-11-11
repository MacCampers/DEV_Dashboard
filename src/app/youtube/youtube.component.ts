import { Component, OnInit } from '@angular/core';
import { Observable } from 'rxjs';
import { YoutubeService } from './youtube.service';
import { DomSanitizer } from '@angular/platform-browser';

@Component({
  selector: 'app-youtube',
  templateUrl: './youtube.component.html',
  styleUrls: ['./youtube.component.css']
})

export class YoutubeComponent implements OnInit {
  public searchValue: string = "";
  public videos: any = []; 
  public videoPath = "";  
  public trustedUrl;
  public description="";
  public title="";
  public showVideoContainer: boolean = false;
  

  constructor(private youtubeService: YoutubeService, private sanitizer: DomSanitizer) {
  }

  ngOnInit() { 
      
  }
  searchVideo() {
    if(this.showVideoContainer==true){
      this.showVideoContainer= false;
    }
    this.youtubeService.searchVideosGet(this.searchValue).subscribe(response => {
      this.videos = response.items;
    });
       
  }

  playVideo(id, description, title) {
    this.title= title;
    this.description= description;
    this.videoPath = `http://www.youtube.com/embed/${id.videoId}?enablejsapi=1&origin=http://example.com`;
    this.trustedUrl = this.sanitizer.bypassSecurityTrustResourceUrl(this.videoPath);
    this.showVideoContainer = true;
  }
}

