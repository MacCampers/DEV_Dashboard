import { TestBed } from '@angular/core/testing';

import { WheatherConfigService } from './wheather-config.service';

describe('WheatherConfigService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: WheatherConfigService = TestBed.get(WheatherConfigService);
    expect(service).toBeTruthy();
  });
});
