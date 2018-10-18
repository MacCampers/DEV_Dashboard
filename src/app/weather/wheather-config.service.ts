import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class WheatherConfigService {

  constructor() { }
  
  public inMemoryApi = false;
}
