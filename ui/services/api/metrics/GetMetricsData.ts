type GetMetricsType = {
    id?: number,
    title?: string,
    description?: string,
    start_date?: string,
    end_date?: string,
    created_at?: string,
    updated_at?: string,
    image_url?: string,
    total_video_size?: number,
    videos_count?: number,
}

export class GetMetricsData {
  public id: number;
  public title: string;
  public description: string;
  public start_date: string;
  public end_date: string;
  public created_at: string;
  public updated_at: string;
  public image_url: string;
  public total_video_size: number;
  public videos_count: number;

  constructor(data: GetMetricsType) {
    this.id = data.id || 0;
    this.title = data.title || '';
    this.description = data.description || '';
    this.start_date = data.start_date || '';
    this.end_date = data.end_date || '';
    this.created_at = data.created_at || '';
    this.updated_at = data.updated_at || '';
    this.image_url = data.image_url || '';
    this.total_video_size = data.total_video_size || 0;
    this.videos_count = data.videos_count || 0;
  }
}
