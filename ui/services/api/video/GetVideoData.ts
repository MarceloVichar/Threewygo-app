type GetVideoType = {
    id?: number,
    title?: string,
    description?: string,
    created_at?: string,
    updated_at?: string,
    image_url?: string,
    video_url?: string,
    course_id?: number|string,
}

export class GetVideoData {
  public id: number;
  public title: string;
  public description: string;
  public created_at: string;
  public updated_at: string;
  public image_url: string;
  public video_url: string;
  public course_id: number|string;

  constructor(data: GetVideoType) {
    this.id = data.id || 0;
    this.title = data.title || '';
    this.description = data.description || '';
    this.created_at = data.created_at || '';
    this.updated_at = data.updated_at || '';
    this.image_url = data.image_url || '';
    this.video_url = data.video_url || '';
    this.course_id = data.course_id || '';
  }
}
